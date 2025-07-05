<?php

namespace App\Controllers;

use App\Models\Klaster4Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;
use App\Models\UserModel;

class Klaster4Controller extends BaseController
{
    protected $klaster4Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster4Model = new Klaster4Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function klaster4($id = null)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $klaster4 = $this->klaster4Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $zipFilePath = FCPATH . 'uploads/klaster4/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id ?? $userId,
            'user_id' => $userId,

            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            'klaster4' => $klaster4,
            'existing' => $klaster4 ?? [],
            'status' => $klaster4['status'] ?? null,
            'zipAvailable' => $zipAvailable,
            'nilai_em' => isset($klaster4['total_nilai']) ? (int) $klaster4['total_nilai'] : 0,
            'nilai_maksimal' => 270,
        ];

        return view('pages/operator/klaster4', $data);
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
            } else {
                $data["{$field}_file"] = null;
            }
        }

        $data['total_nilai'] = $totalNilai;
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
            'nilai_em' => $existing['total_nilai'] ?? 0,
            'nilai_maksimal' => 270,
        ];

        return view('pages/operator/klaster4', $data);
    }

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $klaster4 = $this->klaster4Model->where('user_id', $userId)->first();
        if (!$klaster4) return redirect()->back()->with('error', 'Data Klaster 4 tidak ditemukan.');

        $klasterFormModel = new KlasterFormModel();
        $klasterMeta = $klasterFormModel->where('slug', 'klaster4')->first();
        if (!$klasterMeta) return redirect()->back()->with('error', 'Metadata Klaster tidak ditemukan.');

        $dataBerkas = [
            'user_id' => $userId,
            'klaster' => $klasterMeta['id'],
            'tahun' => $klaster4['tahun'],
            'bulan' => $klaster4['bulan'],
            'total_nilai' => $klaster4['total_nilai'] ?? 0,
            'status' => $status,
            'catatan' => ($status === 'rejected') ? $catatan : null,
            'file_path' => 'klaster4/' . $userId . '.zip',
        ];

        $existingBerkas = $this->berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterMeta['id'])
            ->first();

        if ($existingBerkas) {
            $this->berkasKlasterModel->update($existingBerkas['id'], $dataBerkas);
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
                if (file_exists($filePath)) unlink($filePath);
            }
        }

        $this->klaster4Model->delete($existing['id']);

        return redirect()->to('/klaster4/form')->with('success', 'Pengiriman data dibatalkan. Silakan isi ulang formulir.');
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
                if (file_exists($filePath)) unlink($filePath);
            }
        }

        $this->klaster4Model->delete($klaster4['id']);

        return redirect()->back()->with('success', 'Data Klaster 4 berhasil dihapus.');
    }
}
