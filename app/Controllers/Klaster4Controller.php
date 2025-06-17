<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Klaster4Model;

class Klaster4Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster4Model();
        $userId = session()->get('id');

        $tahun = date('Y');
        $bulan = date('F');

        // Cek apakah user sudah mengisi data untuk tahun & bulan yang sama
        $existing = $model->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi Klaster 4 untuk bulan ini.');
        }

        // Data input dari radio
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'infoAnak' => $this->request->getPost('infoAnak'),
            'kelompokAnak' => $this->request->getPost('kelompokAnak'),
            'partisipasiDini' => $this->request->getPost('partisipasiDini'),
            'belajar12Tahun' => $this->request->getPost('belajar12Tahun'),
            'sekolahRamahAnak' => $this->request->getPost('sekolahRamahAnak'),
            'fasilitasAnak' => $this->request->getPost('fasilitasAnak'),
            'programPerjalanan' => $this->request->getPost('programPerjalanan'),
            'status' => 'pending'
        ];

        // Daftar file fields
        $fileFields = [
            'infoAnak_file',
            'kelompokAnak_file',
            'partisipasiDini_file',
            'belajar12Tahun_file',
            'sekolahRamahAnak_file',
            'fasilitasAnak_file',
            'programPerjalanan_file'
        ];

        // Upload path
        $uploadPath = FCPATH . 'uploads/klaster4/';
        if (!is_dir($uploadPath))
            mkdir($uploadPath, 0777, true);

        // Proses upload file
        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validasi ekstensi file zip
                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berupa ZIP.');
                }

                // Validasi ukuran file (max 1GB)
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file ' . $field . ' terlalu besar (maks 1GB).');
                }

                $newName = $field . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);
                $data[$field] = 'uploads/klaster4/' . $newName;
            }
        }

        // Simpan data
        $model->save($data);

        return redirect()->back()->with('success', 'Data Klaster IV berhasil disimpan dan menunggu persetujuan.');
    }
}
