<?php

namespace App\Controllers;

use App\Models\Klaster1Model;

class Klaster1Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster1Model();
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F'); // gunakan 'm' kalau mau angka

        // ✅ Cek apakah user sudah mengisi untuk tahun & bulan ini
        $existing = $model->where('user_id', $userId)
                          ->where('tahun', $tahun)
                          ->where('bulan', $bulan)
                          ->whereIn('status', ['pending', 'approved'])
                          ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi data Klaster 1 untuk bulan ini dan masih pending atau sudah disetujui.');
        }

        // ✅ Proses upload file
        $files = [];
        foreach (['AnakAktaKelahiran', 'anggaran'] as $field) {
            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 1GB.');
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move('uploads/klaster1/', $newName);
                $files["{$field}_file"] = 'uploads/klaster1/' . $newName;
            } else {
                $files["{$field}_file"] = null;
            }
        }

        // ✅ Simpan data
        $model->save([
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'AnakAktaKelahiran' => $this->request->getPost('AnakAktaKelahiran'),
            'AnakAktaKelahiran_file' => $files['AnakAktaKelahiran_file'],
            'anggaran' => $this->request->getPost('anggaran'),
            'anggaran_file' => $files['anggaran_file'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Data Klaster 1 berhasil disimpan dan menunggu persetujuan!');
    }
}
