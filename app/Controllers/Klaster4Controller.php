<?php

namespace App\Controllers;

use App\Models\Klaster4Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;

class Klaster4Controller extends BaseController
{
    protected $klaster4Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster4Model = new Klaster4Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function submit()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster4Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi form bulan ini dan sedang diproses atau disetujui.');
        }

        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'status' => 'pending',
        ];

        $fields = [
            'infoAnak',
            'kelompokAnak',
            'partisipasiDini',
            'belajar12Tahun',
            'sekolahRamahAnak',
            'fasilitasAnak',
            'programPerjalanan'
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
                $file->move(ROOTPATH . 'public/uploads/klaster4/', $newName);
                $data["{$field}_file"] = $newName;
            }
        }

        // Tambahkan total_nilai ke data
        $data['total_nilai'] = $totalNilai;

        // Simpan ke database
        $this->klaster4Model->insert($data);

        return redirect()->to('/klaster4/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }



    public function form()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster4Model
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
                $existing['infoAnak'] ?? 0,
                $existing['kelompokAnak'] ?? 0,
                $existing['partisipasiDini'] ?? 0,
                $existing['belajar12Tahun'] ?? 0,
                $existing['sekolahRamahAnak'] ?? 0,
                $existing['fasilitasAnak'] ?? 0,
                $existing['programPerjalanan'] ?? 0,
            ]) : 0,
            'nilai_maksimal' => 220, // Ubah sesuai ketentuan
        ];

        return view('pages/operator/klaster4', $data);
    }


    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $klaster4 = $this->klaster4Model
            ->where('user_id', $userId)
            ->first();

        if (!$klaster4) {
            return redirect()->back()->with('error', 'Data Klaster 4 tidak ditemukan.');
        }

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster4')->first();

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
            'tahun' => $klaster4['tahun'],
            'bulan' => $klaster4['bulan'],
            'total_nilai' => $klaster4['total_nilai'] ?? 0,
            'status' => $status,
            'catatan' => $status === 'rejected' ? $catatan : null,
            'file_path' => 'klaster4/' . $userId . '.zip'
        ];

        if ($existing) {
            $this->berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $this->berkasKlasterModel->insert($dataBerkas);
        }

        $this->klaster4Model
            ->where('user_id', $userId)
            ->set(['status' => $status])
            ->update();

        return redirect()->back()->with('success', 'Status Klaster 4 berhasil diperbarui dan disimpan ke laporan.');
    }

    public function batal()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster4Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Tidak ada data yang bisa dibatalkan.');
        }

        // Nama-nama field file yang perlu dicek dan dihapus
        $fileFields = [
            'infoAnak_file',
            'kelompokAnak_file',
            'partisipasiDini_file',
            'belajar12Tahun_file',
            'sekolahRamahAnak_file',
            'fasilitasAnak_file',
            'programPerjalanan_file',
        ];

        foreach ($fileFields as $field) {
            if (!empty($existing[$field])) {
                $filePath = ROOTPATH . 'public/uploads/klaster4/' . $existing[$field];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        // Hapus data dari database
        $this->klaster4Model->delete($existing['id']);

        return redirect()->to('/klaster4/form')->with('success', 'Pengiriman data berhasil dibatalkan. Silakan isi ulang jika perlu.');
    }

    public function delete()
{
    $userId = $this->request->getPost('user_id');

    $klaster4 = $this->klaster4Model
        ->where('user_id', $userId)
        ->where('status', 'rejected')
        ->orderBy('created_at', 'desc')
        ->first();

    if (!$klaster4) {
        return redirect()->back()->with('error', 'Data tidak ditemukan atau status bukan rejected.');
    }

    // Hapus semua file terkait
    $fields = [
        'infoAnak_file',
        'kelompokAnak_file',
        'partisipasiDini_file',
        'belajar12Tahun_file',
        'sekolahRamahAnak_file',
        'fasilitasAnak_file',
        'programPerjalanan_file',
    ];

    foreach ($fields as $field) {
        if (!empty($klaster4[$field])) {
            $filePath = ROOTPATH . 'public/uploads/klaster4/' . $klaster4[$field];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    // Hapus dari database
    $this->klaster4Model->delete($klaster4['id']);

    return redirect()->back()->with('success', 'Data Klaster 4 berhasil dihapus.');
}


}
