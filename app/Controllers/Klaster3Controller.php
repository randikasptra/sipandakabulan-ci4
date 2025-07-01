<?php

namespace App\Controllers;

use App\Models\Klaster3Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;

class Klaster3Controller extends BaseController
{
    protected $klaster3Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster3Model = new Klaster3Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function submit()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Cek existing data
        $existing = $this->klaster3Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi form bulan ini dan sedang diproses atau disetujui.');
        }

        // Inisialisasi data
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'status' => 'pending',
        ];

        $fields = [
            'kematianBayi',
            'giziBalita',
            'asiEksklusif',
            'pojokAsi',
            'pusatKespro',
            'imunisasiAnak',
            'layananAnakMiskin',
            'kawasanTanpaRokok',
        ];

        $totalNilai = 0;

        foreach ($fields as $field) {
            $value = (int) $this->request->getPost($field);
            $data[$field] = $value;
            $totalNilai += $value;

            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->with('error', "Ukuran file {$field} melebihi 10MB.");
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', "File {$field} harus berformat ZIP.");
                }

                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/klaster3/', $newName);
                $data["{$field}_file"] = $newName;
            } else {
                $data["{$field}_file"] = null;
            }
        }

        // Tambahkan total nilai ke data
        $data['total_nilai'] = $totalNilai;

        // Simpan data
        $this->klaster3Model->insert($data);

        return redirect()->to('/klaster3/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }



    public function form()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster3Model
            ->where('user_id', $userId)
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
            'nilai_em' => $existing['total_nilai'] ?? 0,
            'nilai_maksimal' => 220, // bisa kamu sesuaikan
        ];

        return view('pages/operator/klaster3', $data);
    }

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $klaster3 = $this->klaster3Model
            ->where('user_id', $userId)
            ->first();

        if (!$klaster3) {
            return redirect()->back()->with('error', 'Data Klaster 3 tidak ditemukan.');
        }

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster3')->first();

        if (!$klasterData) {
            return redirect()->back()->with('error', 'Data klaster tidak ditemukan.');
        }

        $existing = $this->berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterData['id'])
            ->first();

        $dataBerkas = [
            'user_id' => $userId,
            'klaster' => $klasterData['id'],
            'tahun' => $klaster3['tahun'],
            'bulan' => $klaster3['bulan'],
            'total_nilai' => $klaster3['total_nilai'] ?? 0,
            'status' => $status,
            'catatan' => $status === 'rejected' ? $catatan : null,
            'file_path' => 'klaster3/' . $userId . '.zip'
        ];

        if ($existing) {
            $this->berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $this->berkasKlasterModel->insert($dataBerkas);
        }

        $this->klaster3Model
            ->where('user_id', $userId)
            ->set(['status' => $status])
            ->update();

        return redirect()->back()->with('success', 'Status Klaster 3 berhasil diperbarui dan disimpan ke laporan.');
    }


    public function batal()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster3Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Tidak ada data yang bisa dibatalkan.');
        }

        // Nama-nama field file
        $fileFields = [
            'kematianBayi_file',
            'giziBalita_file',
            'asiEksklusif_file',
            'pojokAsi_file',
            'pusatKespro_file',
            'imunisasiAnak_file',
            'layananAnakMiskin_file',
            'kawasanTanpaRokok_file'
        ];

        // Hapus semua file terkait
        foreach ($fileFields as $field) {
            if (!empty($existing[$field])) {
                $filePath = ROOTPATH . 'public/uploads/klaster3/' . $existing[$field];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Hapus data dari DB
        $this->klaster3Model->delete($existing['id']);

        return redirect()->to('/klaster3/form')->with('success', 'Pengiriman data dibatalkan. Silakan isi ulang formulir.');
    }

}
