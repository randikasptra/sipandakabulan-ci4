<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Klaster5Model;

class Klaster5Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster5Model();
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Cek apakah sudah mengisi untuk bulan dan tahun ini
        $existing = $model->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi form Klaster 5 untuk bulan ini dan sedang menunggu atau sudah disetujui.');
        }

        // Ambil nilai input
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'laporanKekerasanAnak' => (int) $this->request->getPost('laporanKekerasanAnak'),
            'mekanismePenanggulanganBencana' => (int) $this->request->getPost('mekanismePenanggulanganBencana'),
            'programPencegahanKekerasan' => (int) $this->request->getPost('programPencegahanKekerasan'),
            'programPencegahanPekerjaanAnak' => (int) $this->request->getPost('programPencegahanPekerjaanAnak'),
        ];

        // Daftar nama field file
        $fileFields = [
            'laporanKekerasanAnak',
            'mekanismePenanggulanganBencana',
            'programPencegahanKekerasan',
            'programPencegahanPekerjaanAnak'
        ];

        // Path upload
        $uploadPath = FCPATH . 'uploads/klaster5/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Upload file
        foreach ($fileFields as $field) {
            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 1GB.');
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move($uploadPath, $newName);
                $data["{$field}_file"] = $newName;
            }
        }

        // Tambahkan status
        $data['status'] = 'pending';

        $model->save($data);

        return redirect()->to('/klaster5/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }

    public function form()
    {
        $model = new Klaster5Model();
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $model->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->orderBy('created_at', 'desc')
            ->first();

        $data = [
            'user_name' => session()->get('user_name'),
            'user_email' => session()->get('user_email'),
            'user_role' => session()->get('user_role'),
            'status' => $existing['status'] ?? null,
            'existing' => $existing ?? null,
        ];

        return view('pages/operator/klaster5', $data);
    }
}
