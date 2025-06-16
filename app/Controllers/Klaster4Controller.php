<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Klaster4Model;

class Klaster4Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster4Model();
        $id = session()->get('id'); // ambil dari session

        // Data input dari radio
        $data = [
            'user_id'               => $id,
            'infoAnak'              => $this->request->getPost('infoAnak'),
            'kelompokAnak'          => $this->request->getPost('kelompokAnak'),
            'partisipasiDini'       => $this->request->getPost('partisipasiDini'),
            'belajar12Tahun'        => $this->request->getPost('belajar12Tahun'),
            'sekolahRamahAnak'      => $this->request->getPost('sekolahRamahAnak'),
            'fasilitasAnak'         => $this->request->getPost('fasilitasAnak'),
            'programPerjalanan'     => $this->request->getPost('programPerjalanan'),
        ];

        // Daftar field file yang akan dicek
        $fileFields = [
            'infoAnak_file',
            'kelompokAnak_file',
            'partisipasiDini_file',
            'belajar12Tahun_file',
            'sekolahRamahAnak_file',
            'fasilitasAnak_file',
            'programPerjalanan_file'
        ];

        // Buat folder jika belum ada
        $uploadPath = FCPATH . 'uploads/klaster4/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        // Proses upload file
        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $field . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);
                $data[$field] = 'uploads/klaster4/' . $newName;
            }
        }

        // Simpan ke DB
        $model->save($data);

        return redirect()->back()->with('success', 'Data Klaster IV berhasil disimpan!');
    }
}