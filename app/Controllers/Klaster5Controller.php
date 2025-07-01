<?php

namespace App\Controllers;

use App\Models\Klaster5Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;

class Klaster5Controller extends BaseController
{
    protected $klaster5Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster5Model = new Klaster5Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function submit()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster5Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi form Klaster 5 untuk bulan ini dan sedang menunggu atau sudah disetujui.');
        }

        $fields = [
            'laporanKekerasanAnak',
            'mekanismePenanggulanganBencana',
            'programPencegahanKekerasan',
            'programPencegahanPekerjaanAnak'
        ];

        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'status' => 'pending'
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
                $file->move(ROOTPATH . 'public/uploads/klaster5/', $newName);
                $data["{$field}_file"] = $newName;
            }
        }

        // Masukkan total nilai
        $data['total_nilai'] = $totalNilai;

        // Simpan data
        $this->klaster5Model->insert($data);

        return redirect()->to('/klaster5/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }



    public function form()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster5Model
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
            'nilai_em' => isset($existing) ? array_sum([
                $existing['laporanKekerasanAnak'] ?? 0,
                $existing['mekanismePenanggulanganBencana'] ?? 0,
                $existing['programPencegahanKekerasan'] ?? 0,
                $existing['programPencegahanPekerjaanAnak'] ?? 0
            ]) : 0,
            'nilai_maksimal' => 100,
        ];

        return view('pages/operator/klaster5', $data);
    }


    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $klaster5 = $this->klaster5Model->where('user_id', $userId)->first();
        if (!$klaster5) {
            return redirect()->back()->with('error', 'Data Klaster 5 tidak ditemukan.');
        }

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster5')->first();
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
            'tahun' => $klaster5['tahun'],
            'bulan' => $klaster5['bulan'],
            'total_nilai' => 0, // Belum ada di tabel, default 0
            'status' => $status,
            'catatan' => $status === 'rejected' ? $catatan : null,
            'file_path' => 'klaster5/' . $userId . '.zip'
        ];

        if ($existing) {
            $this->berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $this->berkasKlasterModel->insert($dataBerkas);
        }

        $this->klaster5Model->where('user_id', $userId)->set(['status' => $status])->update();

        return redirect()->back()->with('success', 'Status Klaster 5 berhasil diperbarui dan disimpan ke laporan.');
    }

    public function batal()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster5Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Tidak ada data yang bisa dibatalkan.');
        }

        // Daftar nama field yang punya file
        $fileFields = [
            'laporanKekerasanAnak_file',
            'mekanismePenanggulanganBencana_file',
            'programPencegahanKekerasan_file',
            'programPencegahanPekerjaanAnak_file',
        ];

        foreach ($fileFields as $field) {
            if (!empty($existing[$field])) {
                $filePath = ROOTPATH . 'public/uploads/klaster5/' . $existing[$field];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Hapus data dari database
        $this->klaster5Model->delete($existing['id']);

        return redirect()->to('/klaster5/form')->with('success', 'Pengiriman data Klaster 5 berhasil dibatalkan.');
    }


}
