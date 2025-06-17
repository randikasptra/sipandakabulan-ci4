<?php

namespace App\Controllers;

use App\Models\Klaster1Model;

class Klaster1Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster1Model();

        // Ambil ID user dari session
        $userId = session()->get('id'); // Sesuaikan nama session jika berbeda

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

        // Ambil nilai input dan hitung total
        $nilaiAnak = (int) $this->request->getPost('AnakAktaKelahiran');
        $nilaiAnggaran = (int) $this->request->getPost('anggaran');
        $totalNilai = $nilaiAnak + $nilaiAnggaran;

        // Simpan data
        $model->save([
            'user_id' => $userId,
            'AnakAktaKelahiran' => $nilaiAnak,
            'AnakAktaKelahiran_file' => $files['AnakAktaKelahiran_file'],
            'anggaran' => $nilaiAnggaran,
            'anggaran_file' => $files['anggaran_file'],
            'total_nilai' => $totalNilai,
            'status' => 'pending', // default status
        ]);

        return redirect()->back()->with('success', 'Data Klaster 1 berhasil disimpan!');
    }
}
