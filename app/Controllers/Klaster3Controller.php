<?php

namespace App\Controllers;

use App\Models\Klaster3Model;

class Klaster3Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster3Model();
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Cek apakah sudah mengisi untuk bulan ini
        $existing = $model->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi form untuk bulan ini dan sedang menunggu atau sudah disetujui.');
        }

        // Ambil nilai input
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'kematianBayi' => (int) $this->request->getPost('kematianBayi'),
            'giziBalita' => (int) $this->request->getPost('giziBalita'),
            'asiEksklusif' => (int) $this->request->getPost('asiEksklusif'),
            'pojokAsi' => (int) $this->request->getPost('pojokAsi'),
            'pusatKespro' => (int) $this->request->getPost('pusatKespro'),
            'imunisasiAnak' => (int) $this->request->getPost('imunisasiAnak'),
            'layananAnakMiskin' => (int) $this->request->getPost('layananAnakMiskin'),
            'kawasanTanpaRokok' => (int) $this->request->getPost('kawasanTanpaRokok'),
        ];

        // Proses upload file
        $fields = [
            'kematianBayi',
            'giziBalita',
            'asiEksklusif',
            'pojokAsi',
            'pusatKespro',
            'imunisasiAnak',
            'layananAnakMiskin',
            'kawasanTanpaRokok'
        ];

        foreach ($fields as $field) {
            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 1GB.');
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/klaster3/', $newName); // ✅ uploads/ saja
                $data["{$field}_file"] = $newName; // ✅ hanya nama file
            }
        }

        // Tambahkan status
        $data['status'] = 'pending';

        $model->save($data);

        return redirect()->to('/klaster3/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }

    public function form()
    {
        $model = new Klaster3Model();
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

        return view('pages/operator/klaster3', $data);
    }
}
