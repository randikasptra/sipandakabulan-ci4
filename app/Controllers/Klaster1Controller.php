<?php

namespace App\Controllers;

use App\Models\Klaster1Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;

class Klaster1Controller extends BaseController
{
    protected $klaster1Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster1Model = new Klaster1Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function submit()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi data Klaster 1 bulan ini dan masih pending atau sudah disetujui.');
        }

        $AnakAktaKelahiran_value = (int) $this->request->getPost('AnakAktaKelahiran');
        $anggaran_value = (int) $this->request->getPost('anggaran');
        $total_nilai = $AnakAktaKelahiran_value + $anggaran_value;

        $fields = ['AnakAktaKelahiran', 'anggaran'];
        $files = [];

        foreach ($fields as $field) {
            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 1GB.');
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/klaster1/', $newName);
                $files["{$field}_file"] = $newName;
            } else {
                $files["{$field}_file"] = null;
            }
        }

        $this->klaster1Model->save([
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'AnakAktaKelahiran' => $AnakAktaKelahiran_value,
            'AnakAktaKelahiran_file' => $files['AnakAktaKelahiran_file'],
            'anggaran' => $anggaran_value,
            'anggaran_file' => $files['anggaran_file'],
            'total_nilai' => $total_nilai,
            'status' => 'pending',
        ]);

        return redirect()->to('/klaster1/form')->with('success', 'Data Klaster 1 berhasil disimpan dan menunggu persetujuan!');
    }

    public function form()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->orderBy('created_at', 'desc')
            ->first();

        $nilaiEM = isset($existing['total_nilai']) ? (int) $existing['total_nilai'] : 0;

        $data = [
            'user_name' => session()->get('user_name'),
            'user_email' => session()->get('user_email'),
            'user_role' => session()->get('user_role'),
            'status' => $existing['status'] ?? null,
            'existing' => $existing,
            'nilai_em' => $nilaiEM,
            'nilai_maksimal' => 120,
            'total_nilai' => $existing['total_nilai'] ?? null,
        ];

        return view('pages/operator/klaster1', $data);
    }

    public function batal()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Tidak ada data yang bisa dibatalkan.');
        }

        $files = ['AnakAktaKelahiran_file', 'anggaran_file'];
        foreach ($files as $fileField) {
            if (!empty($existing[$fileField])) {
                $filePath = ROOTPATH . 'public/uploads/klaster1/' . $existing[$fileField];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $this->klaster1Model->delete($existing['id']);

        return redirect()->to('/klaster1/form')->with('success', 'Data berhasil dibatalkan. Silakan isi ulang formulir.');
    }

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        $tahun = $this->request->getPost('tahun');
        $bulan = $this->request->getPost('bulan');
        $catatan = $this->request->getPost('catatan');

        $klaster1 = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        if (!$klaster1) {
            return redirect()->back()->with('error', 'Data klaster1 tidak ditemukan.');
        }

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster1')->first();

        if (!$klasterData) {
            return redirect()->back()->with('error', 'Data klaster tidak ditemukan.');
        }

        $existing = $this->berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterData['id'])
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $dataBerkas = [
            'user_id'     => $userId,
            'klaster'     => $klasterData['id'],
            'tahun'       => $tahun,
            'bulan'       => $bulan,
            'total_nilai' => $klaster1['total_nilai'] ?? 0,
            'status'      => $status,
            'catatan'     => $status === 'rejected' ? $catatan : null,
            'file_path'   => 'klaster1/' . $userId . '.zip'
        ];

        if ($existing) {
            $this->berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $this->berkasKlasterModel->insert($dataBerkas);
        }

        // ✅ Update status di klaster1 (dengan syarat lengkap)
        $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->set(['status' => $status])
            ->update();

        return redirect()->back()->with('success', 'Status Klaster 1 berhasil diperbarui.');
    }
}
