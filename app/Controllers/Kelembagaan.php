<?php

namespace App\Controllers;

use App\Models\KelembagaanModel;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;

class Kelembagaan extends BaseController
{
    protected $kelembagaanModel;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->kelembagaanModel = new KelembagaanModel();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function submit()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $kelembagaanModel = new \App\Models\KelembagaanModel();

        $existing = $kelembagaanModel
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        // Jika statusnya pending/approved, tolak input baru
        if ($existing && in_array($existing['status'], ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'Form sudah dikirim atau disetujui. Tidak dapat mengisi ulang.');
        }

        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'peraturan_value' => (int) $this->request->getPost('peraturan'),
            'anggaran_value' => (int) $this->request->getPost('anggaran'),
            'forum_anak_value' => (int) $this->request->getPost('forum_anak'),
            'data_terpilah_value' => (int) $this->request->getPost('data_terpilah'),
            'dunia_usaha_value' => (int) $this->request->getPost('dunia_usaha'),
            'status' => 'pending',
        ];

        $data['total_nilai'] = array_sum([
            $data['peraturan_value'],
            $data['anggaran_value'],
            $data['forum_anak_value'],
            $data['data_terpilah_value'],
            $data['dunia_usaha_value'],
        ]);

        $fields = ['peraturan', 'anggaran', 'forum_anak', 'data_terpilah', 'dunia_usaha'];
        foreach ($fields as $field) {
            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 10MB.');
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/kelembagaan/', $newName);
                $data["{$field}_file"] = $newName;
            }
        }

        if ($existing && $existing['status'] === 'rejected') {
            // update existing data (overwriting rejected)
            $kelembagaanModel->update($existing['id'], $data);
        } else {
            // buat baru
            $kelembagaanModel->insert($data);
        }

        return redirect()->to('/kelembagaan/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }


    public function form()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->kelembagaanModel
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->orderBy('created_at', 'desc')
            ->first();

        $data = [
            'user_name' => session()->get('user_name'),
            'user_email' => session()->get('user_email'),
            'user_role' => session()->get('user_role'),
            'status' => $existing['status'] ?? null,
            'existing' => $existing ?? null,
            'nilai_em' => $existing['total_nilai'] ?? 0,
            'nilai_maksimal' => 220,
        ];

        return view('pages/operator/kelembagaan', $data);
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('berkas_id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $this->berkasKlasterModel->update($id, [
            'status' => $status,
            'catatan' => ($status === 'rejected') ? $catatan : null,
        ]);

        $berkas = $this->berkasKlasterModel->find($id);

        if ($berkas && $berkas['klaster'] == 1) {
            $kelembagaan = $this->kelembagaanModel
                ->where('user_id', $berkas['user_id'])
                ->where('tahun', $berkas['tahun'])
                ->where('bulan', $berkas['bulan'])
                ->first();

            if ($kelembagaan) {
                $this->kelembagaanModel->update($kelembagaan['id'], ['status' => $status]);
            } else {
                log_message('error', 'Data kelembagaan tidak ditemukan untuk user_id: ' . $berkas['user_id'] . ', tahun: ' . $berkas['tahun'] . ', bulan: ' . $berkas['bulan']);
            }
        }

        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui.');
    }

    public function batal()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->kelembagaanModel
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Tidak ada data yang bisa dibatalkan.');
        }

        // Hapus file jika ada
        $fields = ['peraturan_file', 'anggaran_file', 'forum_anak_file', 'data_terpilah_file', 'dunia_usaha_file'];
        foreach ($fields as $fileField) {
            if (!empty($existing[$fileField])) {
                $filePath = ROOTPATH . 'public/uploads/kelembagaan/' . $existing[$fileField];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Hapus data
        $this->kelembagaanModel->delete($existing['id']);

        return redirect()->to('/kelembagaan/form')->with('success', 'Pengiriman data dibatalkan. Silakan isi ulang formulir.');
    }




}
