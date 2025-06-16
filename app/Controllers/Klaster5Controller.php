<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Klaster5Model;

class Klaster5Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster5Model();
        $id = session()->get('id');

        // Data nilai radio
        $data = [
            'user_id'                           => $id,
            'laporanKekerasanAnak'             => $this->request->getPost('laporanKekerasanAnak'),
            'mekanismePenanggulanganBencana'   => $this->request->getPost('mekanismePenanggulanganBencana'),
            'programPencegahanKekerasan'       => $this->request->getPost('programPencegahanKekerasan'),
            'programPencegahanPekerjaanAnak'   => $this->request->getPost('programPencegahanPekerjaanAnak'),
        ];

        // Field file
        $fileFields = [
            'laporanKekerasanAnak_file',
            'mekanismePenanggulanganBencana_file',
            'programPencegahanKekerasan_file',
            'programPencegahanPekerjaanAnak_file'
        ];

        $uploadPath = FCPATH . 'uploads/klaster5/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        // Upload file bila valid
        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $field . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);
                $data[$field] = 'uploads/klaster5/' . $newName;
            }
        }

        $model->save($data);

        return redirect()->back()->with('success', 'Data Klaster V berhasil disimpan!');
    }
}