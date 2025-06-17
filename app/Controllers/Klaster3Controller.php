<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Klaster3Model;

class Klaster3Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster3Model();
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Cek jika sudah isi form bulan ini
        $existing = $model->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi form untuk bulan ini dan sedang diproses atau disetujui.');
        }

        // Data nilai
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'kematianBayi' => $this->request->getPost('kematianBayi'),
            'giziBalita' => $this->request->getPost('giziBalita'),
            'asiEksklusif' => $this->request->getPost('asiEksklusif'),
            'pojokAsi' => $this->request->getPost('pojokAsi'),
            'pusatKespro' => $this->request->getPost('pusatKespro'),
            'imunisasiAnak' => $this->request->getPost('imunisasiAnak'),
            'layananAnakMiskin' => $this->request->getPost('layananAnakMiskin'),
            'kawasanTanpaRokok' => $this->request->getPost('kawasanTanpaRokok'),
        ];

        // File fields
        $fileFields = [
            'kematianBayi_file',
            'giziBalita_file',
            'asiEksklusif_file',
            'pojokAsi_file',
            'pusatKespro_file',
            'imunisasiAnak_file',
            'layananAnakMiskin_file',
            'kawasanTanpaRokok_file',
        ];

        $uploadPath = FCPATH . 'uploads/klaster3/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file ' . $field . ' terlalu besar. Maksimum 1GB.');
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                $newName = $field . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);
                $data[$field] = 'uploads/klaster3/' . $newName;
            }
        }

        // Tambah status pending
        $data['status'] = 'pending';

        $model->save($data);

        return redirect()->back()->with('success', 'Data Klaster III berhasil disimpan dan menunggu persetujuan admin.');
    }
}
