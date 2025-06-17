<?php

namespace App\Controllers;

use App\Models\KelembagaanModel;
use CodeIgniter\Controller;

class Kelembagaan extends Controller
{
    public function submit()
    {
        $model = new KelembagaanModel();
        $userId = session()->get('id');
        $tahun = date('Y');

        // ✅ Cek apakah user sudah mengisi untuk tahun ini dengan status pending/approved
        $existing = $model->where('user_id', $userId)
                          ->where('tahun', $tahun)
                          ->whereIn('status', ['pending', 'approved'])
                          ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi form untuk tahun ini dan sedang menunggu atau sudah disetujui.');
        }

        // ✅ Ambil nilai inputan
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'peraturan_value' => (int) $this->request->getPost('peraturan'),
            'anggaran_value' => (int) $this->request->getPost('anggaran'),
            'forum_anak_value' => (int) $this->request->getPost('forum_anak'),
            'data_terpilah_value' => (int) $this->request->getPost('data_terpilah'),
            'dunia_usaha_value' => (int) $this->request->getPost('dunia_usaha'),
        ];

        // ✅ Hitung total nilai
        $data['total_nilai'] = array_sum([
            $data['peraturan_value'],
            $data['anggaran_value'],
            $data['forum_anak_value'],
            $data['data_terpilah_value'],
            $data['dunia_usaha_value'],
        ]);

        // ✅ Proses file upload ZIP
        $fields = ['peraturan', 'anggaran', 'forum_anak', 'data_terpilah', 'dunia_usaha'];
        foreach ($fields as $field) {
            $file = $this->request->getFile($field . '_file');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 1GB.');
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                $newName = $field . '' . time() . '' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/kelembagaan/', $newName);
                $data[$field . '_file'] = $newName;
            }
        }

        // ✅ Set status default 'pending'
        $data['status'] = 'pending';

        $model->save($data);

        return redirect()->to('/kelembagaan/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }

    public function form()
    {
        $model = new KelembagaanModel();
        $userId = session()->get('id');
        $tahun = date('Y');

        $existing = $model->where('user_id', $userId)
                          ->where('tahun', $tahun)
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
}