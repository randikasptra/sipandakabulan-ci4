<?php

namespace App\Controllers;

use App\Models\KelembagaanModel;
use CodeIgniter\Controller;

class Kelembagaan extends Controller
{
    
    public function submit()
    {
        // dd($_FILES); // Dump semua file

        $model = new KelembagaanModel();
        $user_id = session()->get('user_id');
        $tahun = date('Y');

        // Ambil nilai inputan radio (value numerik)
        $data = [
            'user_id' => $user_id,
            'tahun' => $tahun,
            'peraturan_value' => (int) $this->request->getPost('peraturan'),
            'anggaran_value' => (int) $this->request->getPost('anggaran'),
            'forum_anak_value' => (int) $this->request->getPost('forum_anak'),
            'data_terpilah_value' => (int) $this->request->getPost('data_terpilah'),
            'dunia_usaha_value' => (int) $this->request->getPost('dunia_usaha'),
        ];

        // Hitung total nilai otomatis
        $data['total_nilai'] =
            $data['peraturan_value'] +
            $data['anggaran_value'] +
            $data['forum_anak_value'] +
            $data['data_terpilah_value'] +
            $data['dunia_usaha_value'];

        // Proses upload file ZIP (pastikan nama input file di form sama)
        $fields = ['peraturan', 'anggaran', 'forum_anak', 'data_terpilah', 'dunia_usaha'];
        foreach ($fields as $field) {
            $file = $this->request->getFile($field . '_file');


            if ($file && $file->isValid() && !$file->hasMoved()) {

                // ✅ Cek ukuran maksimum 1 GB (dalam byte)
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 1GB.');
                }

                // ✅ Pastikan file berformat .zip
                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus ZIP.');
                }

                // ✅ Simpan file
                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/kelembagaan/', $newName);

                $data[$field . '_file'] = $newName;

            } else {
                // ✅ Logging debug jika file tidak valid / tidak diupload
                log_message('debug', "File {$field}_file: " . ($file ? $file->getName() : 'NULL') .
                    ' | Valid: ' . ($file && $file->isValid() ? 'yes' : 'no') .
                    ' | Moved: ' . ($file && $file->hasMoved() ? 'yes' : 'no'));
            }

        }

        // Simpan ke database
        $model->save($data);

        return redirect()->to('/kelembagaan/form')->with('success', 'Data berhasil disimpan.');
    }

    public function form()
    {
        $data = [
            'user_name' => session()->get('user_name'),
            'user_email' => session()->get('user_email'),
            'user_role' => session()->get('user_role'),
            'status' => 'pending',
            'nilai_em' => 0,
            'nilai_maksimal' => 220,
        ];

        return view('pages/operator/kelembagaan', $data);
    }
}
