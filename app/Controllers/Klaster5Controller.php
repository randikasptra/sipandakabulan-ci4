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
        $tahun = date('Y');
        $bulan = date('F'); // Nama bulan, misalnya: January, February, dst.

        // 🔍 Cek jika user sudah submit tahun ini (opsional, jika ingin dibatasi 1x per tahun)
        $existing = $model->where('user_id', $id)
            ->where('tahun', $tahun)
            ->where('status !=', 'rejected')
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Data untuk tahun ini sudah diajukan.');
        }

        // 📥 Data nilai radio
        $data = [
            'user_id' => $id,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'laporanKekerasanAnak' => (int) $this->request->getPost('laporanKekerasanAnak'),
            'mekanismePenanggulanganBencana' => (int) $this->request->getPost('mekanismePenanggulanganBencana'),
            'programPencegahanKekerasan' => (int) $this->request->getPost('programPencegahanKekerasan'),
            'programPencegahanPekerjaanAnak' => (int) $this->request->getPost('programPencegahanPekerjaanAnak'),
            'status' => 'pending', // default status
        ];

        // 📂 File upload
        $fileFields = [
            'laporanKekerasanAnak_file',
            'mekanismePenanggulanganBencana_file',
            'programPencegahanKekerasan_file',
            'programPencegahanPekerjaanAnak_file'
        ];

        $uploadPath = FCPATH . 'uploads/klaster5/';
        if (!is_dir($uploadPath))
            mkdir($uploadPath, 0777, true);

        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File untuk ' . $field . ' harus dalam format ZIP.');
                }

                $newName = $field . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);
                $data[$field] = 'uploads/klaster5/' . $newName;
            }
        }

        // 💾 Simpan
        $model->save($data);

        return redirect()->back()->with('success', 'Data Klaster V berhasil disimpan dan sedang menunggu persetujuan admin.');
    }

    public function form()
    {
        $model = new Klaster5Model();
        $userId = session()->get('id');
        $tahun = date('Y');

        $existing = $model->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->orderBy('created_at', 'desc')
            ->first();

        $data = [
            'user_name' => session()->get('user_name'),
            'status' => $existing['status'] ?? null,
            'existing' => $existing ?? null,
        ];

        return view('pages/operator/klaster5', $data);
    }
}
