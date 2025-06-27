<?php

namespace App\Controllers;

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

        // Ambil nilai input radio
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'laporanKekerasanAnak' => (int) $this->request->getPost('laporanKekerasanAnak'),
            'mekanismePenanggulanganBencana' => (int) $this->request->getPost('mekanismePenanggulanganBencana'),
            'programPencegahanKekerasan' => (int) $this->request->getPost('programPencegahanKekerasan'),
            'programPencegahanPekerjaanAnak' => (int) $this->request->getPost('programPencegahanPekerjaanAnak'),
        ];

        // Daftar field upload file
        $fields = [
            'laporanKekerasanAnak',
            'mekanismePenanggulanganBencana',
            'programPencegahanKekerasan',
            'programPencegahanPekerjaanAnak'
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

                // Simpan file ke uploads/klaster5/
                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/klaster5/', $newName);
                $data["{$field}_file"] = $newName; // hanya nama file
            }
        }

        // Tambahkan status
        $data['status'] = 'pending';

        // Simpan ke database
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

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status'); // 'approved' atau 'rejected'

        $klaster5Model = new \App\Models\Klaster5Model();
        $berkasKlasterModel = new \App\Models\BerkasKlasterModel();
        $klasterFormModel = new \App\Models\KlasterFormModel();

        // Ambil data klaster5 user
        $klaster5 = $klaster5Model->where('user_id', $userId)->first();
        if (!$klaster5) {
            return redirect()->back()->with('error', 'Data Klaster 5 tidak ditemukan.');
        }

        // Ambil ID klaster dari slug
        $klasterData = $klasterFormModel->where('slug', 'klaster5')->first();
        if (!$klasterData) {
            return redirect()->back()->with('error', 'Klaster tidak ditemukan.');
        }

        // Cek apakah data sudah ada di berkas_klaster
        $existing = $berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterData['id'])
            ->first();

        $dataBerkas = [
            'user_id' => $userId,
            'klaster' => $klasterData['id'],
            'tahun' => $klaster5['tahun'],
            'bulan' => $klaster5['bulan'],
            'total_nilai' => $klaster5['total_nilai'] ?? 0,
            'status' => $status,
            'catatan' => $status === 'rejected' ? $this->request->getPost('catatan') : null,
            'file_path' => 'klaster5/' . $userId . '.zip' // atau sesuaikan file zip-nya
        ];

        if ($existing) {
            $berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $berkasKlasterModel->insert($dataBerkas);
        }

        // Update status di klaster5
        $klaster5Model->where('user_id', $userId)->set(['status' => $status])->update();

        return redirect()->back()->with('success', 'Status Klaster 5 berhasil diperbarui dan disimpan ke laporan.');
    }

}
