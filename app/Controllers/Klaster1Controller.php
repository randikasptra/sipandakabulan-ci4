<?php

namespace App\Controllers;

use App\Models\Klaster1Model;
use App\Models\BerkasKlasterModel;

class Klaster1Controller extends BaseController
{
    protected $klaster1Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster1Model = new Klaster1Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function submit()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F'); // gunakan 'm' kalau mau angka

        // ✅ Cek apakah user sudah mengisi untuk tahun & bulan ini
        $existing = $this->klaster1Model
            ->where('user_id', $userId)
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
                $file->move(ROOTPATH . 'public/uploads/klaster1/', $newName);
                $files["{$field}_file"] = $newName;
            } else {
                $files["{$field}_file"] = null;
            }
        }

        // ✅ Simpan data klaster1
        $this->klaster1Model->save([
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

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status'); // approved / rejected

        // ✅ Inisialisasi model
        $klaster1Model = new \App\Models\Klaster1Model();
        $berkasKlasterModel = new \App\Models\BerkasKlasterModel();

        // ✅ Ambil data dari klaster1
        $klaster1 = $klaster1Model->where('user_id', $userId)->first();

        if (!$klaster1) {
            return redirect()->back()->with('error', 'Data klaster1 tidak ditemukan.');
        }

        // ✅ Simpan ke tabel berkas_klaster
        $berkasKlasterModel->save([
            'user_id' => $userId,
            'klaster' => 'klaster1',
            'tahun' => $klaster1['tahun'],
            'bulan' => $klaster1['bulan'],
            'total_nilai' => $klaster1['total_nilai'] ?? 0,
            'status' => $status,
            'catatan' => '', // nanti bisa diisi kalau perlu
        ]);

        // ✅ Update status di klaster1
        $klaster1Model->where('user_id', $userId)->set(['status' => $status])->update();

        return redirect()->back()->with('success', 'Status klaster1 berhasil diperbarui.');
    }

}
