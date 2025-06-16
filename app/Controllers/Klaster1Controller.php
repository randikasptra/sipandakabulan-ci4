<?php

namespace App\Controllers;

use App\Models\Klaster1Model;

class Klaster1Controller extends BaseController
{
    public function index()
    {
        $data = [
            'user_name' => session()->get('name'),
            'user_email' => session()->get('email'),
            'user_role' => session()->get('role'),
            'status' => 'pending',
            'nilai_em' => 0,
            'nilai_maksimal' => 120
        ];

        return view('klaster1/form', $data);
    }

    public function submit()
    {

        dd($this->request->getPost(), $this->request->getFiles());
        $model = new Klaster1Model();
        $user_id = session()->get('id');

        // Validasi upload ZIP max 2GB
        $validationRule = [
            'AnakAktaKelahiran_file' => [
                'label' => 'Dokumen Akta Kelahiran',
                'rules' => 'uploaded[AnakAktaKelahiran_file]|max_size[AnakAktaKelahiran_file,2048000]|ext_in[AnakAktaKelahiran_file,zip]',
            ],
            'anggaran_file' => [
                'label' => 'Dokumen Anggaran',
                'rules' => 'uploaded[anggaran_file]|max_size[anggaran_file,2048000]|ext_in[anggaran_file,zip]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $aktaFile = $this->request->getFile('AnakAktaKelahiran_file');
        $anggaranFile = $this->request->getFile('anggaran_file');

        // Save ZIPs
        $aktaName = $aktaFile->getRandomName();
        $aktaFile->move('uploads/klaster1', $aktaName);

        $anggaranName = $anggaranFile->getRandomName();
        $anggaranFile->move('uploads/klaster1', $anggaranName);

        $model->save([
            'user_id' => $user_id,
            'AnakAktaKelahiran' => $this->request->getPost('AnakAktaKelahiran'),
            'AnakAktaKelahiran_file' => $aktaName,
            'anggaran' => $this->request->getPost('anggaran'),
            'anggaran_file' => $anggaranName,
        ]);

        return redirect()->to('/klaster1')->with('success', 'Data berhasil disimpan!');
    }
}