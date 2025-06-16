<?php
namespace App\Controllers;

use App\Models\Klaster2Model;

class Klaster2Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster2Model();

        // Ambil ID Desa/User dari session
        $id = session()->get('id'); // GANTI sesuai session yang kamu pakai

        // Simpan file
        $files = [];
        foreach (['perkawinanAnak', 'pencegahanPernikahan', 'lembagaKonsultasi'] as $field) {
            $file = $this->request->getFile("{$field}_file");
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/klaster2/', $newName);
                $files["{$field}_file"] = 'uploads/klaster2/' . $newName;
            } else {
                $files["{$field}_file"] = null;
            }
        }

        // Simpan ke database
        $model->save([
            'user_id' => $id, // ID user dari session
            'perkawinanAnak' => $this->request->getPost('perkawinanAnak'),
            'perkawinanAnak_file' => $files['perkawinanAnak_file'],
            'pencegahanPernikahan' => $this->request->getPost('pencegahanPernikahan'),
            'pencegahanPernikahan_file' => $files['pencegahanPernikahan_file'],
            'lembagaKonsultasi' => $this->request->getPost('lembagaKonsultasi'),
            'lembagaKonsultasi_file' => $files['lembagaKonsultasi_file'],
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}