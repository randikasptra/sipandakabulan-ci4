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
    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status'); // 'approved' atau 'rejected'

        $klaster3Model = new \App\Models\Klaster3Model();
        $berkasKlasterModel = new \App\Models\BerkasKlasterModel();
        $klasterFormModel = new \App\Models\KlasterFormModel();

        // Ambil data klaster3 milik user
        $klaster3 = $klaster3Model->where('user_id', $userId)->first();
        if (!$klaster3) {
            return redirect()->back()->with('error', 'Data Klaster 3 tidak ditemukan.');
        }

        // Ambil ID klaster dari slug
        $klasterData = $klasterFormModel->where('slug', 'klaster3')->first();
        if (!$klasterData) {
            return redirect()->back()->with('error', 'Klaster tidak ditemukan.');
        }

        // Cek apakah data sudah ada di berkas_klaster
        $existing = $berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterData['id'])
            ->first();

        // Siapkan data berkas
        $dataBerkas = [
            'user_id' => $userId,
            'klaster' => $klasterData['id'],
            'tahun' => $klaster3['tahun'],
            'bulan' => $klaster3['bulan'],
            'total_nilai' => $klaster3['total_nilai'] ?? 0,
            'status' => $status,
            'catatan' => $status === 'rejected' ? $this->request->getPost('catatan') : null,
            'file_path' => 'klaster3/' . $userId . '.zip' // opsional, sesuaikan dengan sistem file kamu
        ];

        if ($existing) {
            $berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $berkasKlasterModel->insert($dataBerkas);
        }

        // Update status klaster3
        $klaster3Model->where('user_id', $userId)->set(['status' => $status])->update();

        return redirect()->back()->with('success', 'Status Klaster 3 berhasil diperbarui dan disimpan ke laporan.');
    }

}
