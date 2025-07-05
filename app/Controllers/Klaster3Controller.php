<?php

namespace App\Controllers;

use App\Models\Klaster3Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;
use App\Models\UserModel;

class Klaster3Controller extends BaseController
{
    protected $klaster3Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster3Model = new Klaster3Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function klaster3($id = null)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $klaster3 = $this->klaster3Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $zipFilePath = FCPATH . 'uploads/klaster3/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id ?? $userId,
            'user_id' => $userId,
            'klaster3' => $klaster3,
            'existing' => $klaster3 ?? [],
            'status' => $klaster3['status'] ?? null,
             'nilai_em' => $klaster3['total_nilai'] ?? 0,
            'nilai_maksimal' => 180,
            'zipAvailable' => $zipAvailable,
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),
        ];

        return view('pages/operator/klaster3', $data);
    }

    public function submit()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster3Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Form sudah dikirim atau disetujui. Tidak dapat mengisi ulang.');
        }

        $fields = [
            'kematianBayi', 'giziBalita', 'asiEksklusif', 'pojokAsi',
            'pusatKespro', 'imunisasiAnak', 'layananAnakMiskin', 'kawasanTanpaRokok'
        ];

        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'status' => 'pending',
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

        $data['total_nilai'] = $totalNilai;
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
            'existing' => $existing,
            'nilai_em' => $existing['total_nilai'] ?? 0,
            'nilai_maksimal' => 180,
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
            ->orderBy('created_at', 'desc')
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
            ->where('tahun', $klaster3['tahun'])
            ->where('bulan', $klaster3['bulan'])
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
            ->where('tahun', $klaster3['tahun'])
            ->where('bulan', $klaster3['bulan'])
            ->set(['status' => $status])
            ->update();

        return redirect()->back()->with('success', 'Status Klaster 3 berhasil diperbarui.');
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

        $fields = [
            'kematianBayi_file', 'giziBalita_file', 'asiEksklusif_file', 'pojokAsi_file',
            'pusatKespro_file', 'imunisasiAnak_file', 'layananAnakMiskin_file', 'kawasanTanpaRokok_file'
        ];

        foreach ($fields as $field) {
            if (!empty($existing[$field])) {
                $filePath = ROOTPATH . 'public/uploads/klaster3/' . $existing[$field];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $this->klaster3Model->delete($existing['id']);

        return redirect()->to('/klaster3/form')->with('success', 'Pengiriman data dibatalkan. Silakan isi ulang formulir.');
    }

    public function delete()
    {
        $userId = $this->request->getPost('user_id');
        $tahun = date('Y');
        $bulan = date('F');

        $klaster3 = $this->klaster3Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'rejected')
            ->first();

        if (!$klaster3) {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau belum ditolak.');
        }

        $fields = [
            'kematianBayi_file', 'giziBalita_file', 'asiEksklusif_file', 'pojokAsi_file',
            'pusatKespro_file', 'imunisasiAnak_file', 'layananAnakMiskin_file', 'kawasanTanpaRokok_file'
        ];

        foreach ($fields as $field) {
            if (!empty($klaster3[$field])) {
                $filePath = ROOTPATH . 'public/uploads/klaster3/' . $klaster3[$field];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $this->klaster3Model->delete($klaster3['id']);

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster3')->first();

        if ($klasterData) {
            $this->berkasKlasterModel
                ->where('user_id', $userId)
                ->where('klaster', $klasterData['id'])
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->delete();
        }

        return redirect()->back()->with('success', 'Data Klaster 3 berhasil dihapus permanen.');
    }
}
