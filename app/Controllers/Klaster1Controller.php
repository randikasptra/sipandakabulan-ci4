<?php

namespace App\Controllers;

use App\Models\Klaster1Model;

class Klaster1Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster1Model();

        // Ambil ID user dari session
        $userId = session()->get('id'); // GANTI sesuai nama session user kamu

        // Upload file
        $files = [];
        foreach (['AnakAktaKelahiran', 'anggaran'] as $field) {
            $file = $this->request->getFile("{$field}_file");
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/klaster1/', $newName);
                $files["{$field}_file"] = 'uploads/klaster1/' . $newName;
            } else {
                $files["{$field}_file"] = null;
            }
        }

        // Simpan data
        $model->save([
            'user_id' => $userId,
            'AnakAktaKelahiran' => $this->request->getPost('AnakAktaKelahiran'),
            'AnakAktaKelahiran_file' => $files['AnakAktaKelahiran_file'],
            'anggaran' => $this->request->getPost('anggaran'),
            'anggaran_file' => $files['anggaran_file'],
        ]);

        return redirect()->back()->with('success', 'Data Klaster 1 berhasil disimpan!');
    }
}