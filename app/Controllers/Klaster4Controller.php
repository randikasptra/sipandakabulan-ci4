<?php

namespace App\Controllers;

use App\Models\Klaster4Model;

class Klaster4Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster4Model();
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
            return redirect()->back()->with('error', 'Kamu sudah mengisi form untuk bulan ini dan sedang menunggu atau sudah disetujui.');
        }

        // Ambil nilai input radio
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'infoAnak' => (int) $this->request->getPost('infoAnak'),
            'kelompokAnak' => (int) $this->request->getPost('kelompokAnak'),
            'partisipasiDini' => (int) $this->request->getPost('partisipasiDini'),
            'belajar12Tahun' => (int) $this->request->getPost('belajar12Tahun'),
            'sekolahRamahAnak' => (int) $this->request->getPost('sekolahRamahAnak'),
            'fasilitasAnak' => (int) $this->request->getPost('fasilitasAnak'),
            'programPerjalanan' => (int) $this->request->getPost('programPerjalanan'),
        ];

        // Daftar field upload file
        $fields = [
            'infoAnak',
            'kelompokAnak',
            'partisipasiDini',
            'belajar12Tahun',
            'sekolahRamahAnak',
            'fasilitasAnak',
            'programPerjalanan'
        ];


        foreach ($fields as $field) {
            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validasi ukuran
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 1GB.');
                }

                // Validasi ekstensi
                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                // Simpan file ke uploads/ saja (tanpa folder klaster4/)
                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/klaster4/', $newName);
                $data["{$field}_file"] = $newName; // hanya nama file
            }
        }

        // Tambahkan status
        $data['status'] = 'pending';

        // Simpan ke database
        $model->save($data);

        return redirect()->to('/klaster4/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }

    public function form()
    {
        $model = new Klaster4Model();
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

        return view('pages/operator/klaster4', $data);
    }

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');

        $klaster4Model = new \App\Models\Klaster4Model();
        $berkasKlasterModel = new \App\Models\BerkasKlasterModel();
        $klasterFormModel = new \App\Models\KlasterFormModel();

        $klaster4 = $klaster4Model->where('user_id', $userId)->first();
        if (!$klaster4) {
            return redirect()->back()->with('error', 'Data Klaster 4 tidak ditemukan.');
        }

        $klasterData = $klasterFormModel->where('slug', 'klaster4')->first();
        if (!$klasterData) {
            return redirect()->back()->with('error', 'Klaster tidak ditemukan.');
        }

        $existing = $berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterData['id'])
            ->first();

        $dataBerkas = [
            'user_id' => $userId,
            'klaster' => $klasterData['id'],
            'tahun' => $klaster4['tahun'],
            'bulan' => $klaster4['bulan'],
            'total_nilai' => $klaster4['total_nilai'] ?? 0,
            'status' => $status,
            'catatan' => $status === 'rejected' ? $this->request->getPost('catatan') : null,
            'file_path' => 'klaster4/' . $userId . '.zip'
        ];

        if ($existing) {
            $berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $berkasKlasterModel->insert($dataBerkas);
        }

        $klaster4Model->where('user_id', $userId)->set(['status' => $status])->update();

        return redirect()->back()->with('success', 'Status Klaster 4 berhasil diperbarui dan disimpan ke laporan.');
    }

}
