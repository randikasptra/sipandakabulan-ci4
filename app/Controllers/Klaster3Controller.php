<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Klaster3Model;

class Klaster3Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster3Model();
        $id = session()->get('id');

        $data = [
            'user_id' => $id,
            'kematianBayi' => $this->request->getPost('kematianBayi'),
            'giziBalita' => $this->request->getPost('giziBalita'),
            'asiEksklusif' => $this->request->getPost('asiEksklusif'),
            'pojokAsi' => $this->request->getPost('pojokAsi'),
            'pusatKespro' => $this->request->getPost('pusatKespro'),
            'imunisasiAnak' => $this->request->getPost('imunisasiAnak'),
            'layananAnakMiskin' => $this->request->getPost('layananAnakMiskin'),
            'kawasanTanpaRokok' => $this->request->getPost('kawasanTanpaRokok'),
        ];

        $fileFields = [
            'kematianBayi_file',
            'giziBalita_file',
            'asiEksklusif_file',
            'pojokAsi_file',
            'pusatKespro_file',
            'imunisasiAnak_file',
            'layananAnakMiskin_file',
            'kawasanTanpaRokok_file'
        ];

        $uploadPath = FCPATH . 'uploads/klaster3/';
        if (!is_dir($uploadPath))
            mkdir($uploadPath, 0777, true);

        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid()) {
                $newName = $field . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);
                $data[$field] = 'uploads/klaster3/' . $newName;
            }
        }

        $model->save($data);

        return redirect()->back()->with('success', 'Data Klaster III berhasil disimpan!');
    }
}