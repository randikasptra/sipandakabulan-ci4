<?php

namespace App\Controllers;

use App\Models\Klaster1Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;
use App\Models\UserModel;

class Klaster1Controller extends BaseController
{
    protected $klaster1Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster1Model = new Klaster1Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function klaster1($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $klaster1 = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $zipFilePath = FCPATH . 'uploads/klaster1/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'user_name' => $session->get('username'),
            'id' => $id ?? $userId,
            'klaster1' => $klaster1,
            'zipAvailable' => $zipAvailable,
            'user_id' => $userId,

            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            'existing' => $klaster1 ?? [],
            'status' => $klaster1['status'] ?? null,
            'nilai_em' => isset($klaster1['total_nilai']) ? (int) $klaster1['total_nilai'] : 0,
            'nilai_maksimal' => 120,
        ];

        return view('pages/operator/klaster1', $data);
    }

   public function submit()
{
    $userId = session()->get('id');
    $tahun = date('Y');
    $bulan = date('F');

    $existing = $this->klaster1Model
        ->where('user_id', $userId)
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->first();

    if ($existing && in_array($existing['status'], ['pending', 'approved'])) {
        return redirect()->back()->with('error', 'Form sudah dikirim atau disetujui. Tidak dapat mengisi ulang.');
    }

    $data = [
        'user_id' => $userId,
        'tahun' => $tahun,
        'bulan' => $bulan,
        'AnakAktaKelahiran' => (int) $this->request->getPost('AnakAktaKelahiran'),
        'anggaran' => (int) $this->request->getPost('anggaran'),
        'status' => 'pending',
    ];

    $data['total_nilai'] = $data['AnakAktaKelahiran'] + $data['anggaran'];

    $fields = ['AnakAktaKelahiran', 'anggaran'];
    foreach ($fields as $field) {
        $file = $this->request->getFile("{$field}_file");
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() > 10 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 10MB.');
            }
            if ($file->getExtension() !== 'zip') {
                return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
            }

            $newName = $field . '_' . time() . '_' . $file->getClientName();
            $file->move(ROOTPATH . 'public/uploads/klaster1/', $newName);
            $data[$field . '_file'] = $newName;
        }
    }

    try {
        if ($existing && $existing['status'] === 'rejected') {
            $this->klaster1Model->update($existing['id'], $data);
        } else {
            $this->klaster1Model->insert($data);
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);
        if ($user) {
            session()->set([
                'user_email' => $user['email'],
                'user_name' => $user['username'],
                'user_role' => $user['role'],
            ]);
        }

        // ✅ Set flashdata SweetAlert
        return redirect()->to('/klaster1/form')->with('success', 'Data berhasil dikirim. Menunggu persetujuan admin.');

    } catch (\Exception $e) {
        // ❌ Jika error terjadi
        return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
    }
}

    public function form()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster1Model
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
            'nilai_em' => isset($existing['total_nilai']) ? (int) $existing['total_nilai'] : 0,
            'nilai_maksimal' => 120,
        ];

        return view('pages/operator/klaster1', $data);
    }

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        $tahun = $this->request->getPost('tahun');
        $bulan = $this->request->getPost('bulan');
        $catatan = $this->request->getPost('catatan');

        $klaster1 = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        if (!$klaster1) {
            return redirect()->back()->with('error', 'Data Klaster 1 tidak ditemukan.');
        }

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster1')->first();

        if (!$klasterData) {
            return redirect()->back()->with('error', 'Data klaster tidak ditemukan.');
        }

        $existing = $this->berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterData['id'])
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $dataBerkas = [
            'user_id'     => $userId,
            'klaster'     => $klasterData['id'],
            'tahun'       => $tahun,
            'bulan'       => $bulan,
            'total_nilai' => $klaster1['total_nilai'] ?? 0,
            'status'      => $status,
            'catatan'     => $status === 'rejected' ? $catatan : null,
            'file_path'   => 'klaster1/' . $userId . '.zip'
        ];

        if ($existing) {
            $this->berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $this->berkasKlasterModel->insert($dataBerkas);
        }

        $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->set(['status' => $status])
            ->update();

        // return redirect()->back()->with('success', 'Status Klaster 1 berhasil diperbarui.');
        $userId = $this->request->getPost('user_id');
          if ($status === 'rejected') {
            return redirect()->to('dashboard/admin/approve/' . $userId)->with('success', 'Status berhasil di Tolak.');
        }
        return redirect()->to('dashboard/berkas')->with('success', 'Berkas di Setujui.');

    }

    public function delete()
    {
        $userId = $this->request->getPost('user_id');
        $tahun = $this->request->getPost('tahun');
        $bulan = $this->request->getPost('bulan');

        $existing = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'rejected')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau belum ditolak.');
        }

        $fileFields = ['AnakAktaKelahiran_file', 'anggaran_file'];
        foreach ($fileFields as $field) {
            if (!empty($existing[$field])) {
                $filePath = ROOTPATH . 'public/uploads/klaster1/' . $existing[$field];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } 
        }

        $this->klaster1Model->delete($existing['id']);

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster1')->first();

        if ($klasterData) {
            $this->berkasKlasterModel
                ->where('user_id', $userId)
                ->where('klaster', $klasterData['id'])
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->delete();
        }

        return redirect()->back()->with('success', 'Data Klaster 1 berhasil dihapus permanen.');
    }

    public function batal()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Tidak ada data yang bisa dibatalkan.');
        }

        $fields = ['AnakAktaKelahiran_file', 'anggaran_file'];
        foreach ($fields as $fileField) {
            if (!empty($existing[$fileField])) {
                $filePath = ROOTPATH . 'public/uploads/klaster1/' . $existing[$fileField];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $this->klaster1Model->delete($existing['id']);

        return redirect()->to('/klaster1/form')->with('success', 'Pengiriman data dibatalkan. Silakan isi ulang formulir.');
    }


   public function deleteApproveKlaster1()
{
    $userId = $this->request->getPost('user_id');
    $tahun = date('Y');
    $bulan = date('F');

    $klaster1Model = new \App\Models\Klaster1Model();

    // Cari data klaster1 yang approved di bulan & tahun ini
    $existing = $klaster1Model
        ->where('user_id', $userId)
        ->where('status', 'approved')
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->first();

    if (!$existing) {
        return redirect()->back()->with('error', 'Data Klaster 1 dengan status approved tidak ditemukan.');
    }

    // File yang akan dicek dan dihapus
    $fields = ['AnakAktaKelahiran_file', 'anggaran_file'];
    foreach ($fields as $fileField) {
        if (!empty($existing[$fileField])) {
            $filePath = ROOTPATH . 'public/uploads/klaster1/' . $existing[$fileField];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    // Hapus dari database
    $klaster1Model->delete($existing['id']);

    return redirect()->to('dashboard/admin/approve/' . $userId)
        ->with('success', 'Data Klaster 1 berhasil dihapus.');
}


}