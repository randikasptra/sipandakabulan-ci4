<?php

namespace App\Controllers;

use App\Models\KlasterFormModel;
use App\Models\UserModel;
use App\Models\AnnouncementModel;

class Dashboard extends BaseController
{
    protected $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
    }

    public function kelembagaan($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $kelembagaanModel = new \App\Models\KelembagaanModel();

        $tahun = date('Y');
        $bulan = date('F'); // Pastikan sama dengan saat submit()

        $kelembagaan = $kelembagaanModel
            ->where('user_id', session()->get('id'))

            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $zipFilePath = FCPATH . 'uploads/kelembagaan/' . $id . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
            'kelembagaan' => $kelembagaan,
            'zipAvailable' => $zipAvailable,
            'user_id' => $id,

            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            // penting
            'existing' => $kelembagaan ?? [],
            'status' => $kelembagaan['status'] ?? null,
        ];

        return view('pages/operator/kelembagaan', $data);
    }




    public function pengumuman_user()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $desa_operator = $session->get('desa'); // ✅ Pastikan saat login, 'desa' disimpan ke session

        // Debug sementara
        // dd($desa_operator, $session->get());

        $pengumuman = $this->announcementModel
            ->groupStart()
            ->where('tujuan_desa', $desa_operator)
            ->orWhere('tujuan_desa IS NULL', null, false) // ✅ Untuk pengumuman ke semua desa
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'pengumuman' => $pengumuman
        ];

        return view('pages/operator/pengumuman_user', $data);
    }


    public function klaster1($id = null)
    {
        $session = session();

        // Cek login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster1Model = new \App\Models\Klaster1Model();

        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F'); // sesuaikan dengan format penyimpanan kamu

        // Ambil data klaster1 berdasarkan session user ID
        $klaster1 = $klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        // Cek file ZIP berdasarkan userId atau dari $id
        $zipFilePath = FCPATH . 'uploads/klaster1/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id ?? $userId,
            'user_id' => $userId,

            // Statistik
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            // Form data
            'klaster1' => $klaster1,
            'existing' => $klaster1 ?? [],
            'status' => $klaster1['status'] ?? null,
            'zipAvailable' => $zipAvailable,
        ];

        return view('pages/operator/klaster1', $data);
    }





    public function klaster2($id = null)
    {
        $session = session();

        // Cek apakah user sudah login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster2Model = new \App\Models\Klaster2Model();

        $tahun = date('Y');
        $bulan = date('F');

        // ✅ Ambil user_id dari session
        $userId = $session->get('id');

        // Ambil data klaster2 berdasarkan session user ID
        $klaster2 = $klaster2Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        // Cek apakah file ZIP-nya tersedia (pakai ID dari argumen URL untuk nama file jika perlu)
        $zipFilePath = FCPATH . 'uploads/klaster2/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id ?? $userId,
            'user_id' => $userId,
            'klaster2' => $klaster2,
            'zipAvailable' => $zipAvailable,

            // Statistik
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            // Status & data form
            'existing' => $klaster2 ?? [],
            'status' => $klaster2['status'] ?? null,
        ];

        return view('pages/operator/klaster2', $data);
    }



    public function klaster3($id = null)
    {
        $session = session();

        // Cek login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster3Model = new \App\Models\Klaster3Model();

        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Ambil data klaster3 berdasarkan session user ID
        $klaster3 = $klaster3Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        // Cek apakah file ZIP-nya tersedia
        $zipFilePath = FCPATH . 'uploads/klaster3/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id ?? $userId,
            'user_id' => $userId,

            // Statistik
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            // Data form
            'klaster3' => $klaster3,
            'existing' => $klaster3 ?? [],
            'status' => $klaster3['status'] ?? null,
            'zipAvailable' => $zipAvailable,
        ];

        return view('pages/operator/klaster3', $data);
    }


    public function klaster4($id = null)
    {
        $session = session();

        // Cek login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster4Model = new \App\Models\Klaster4Model();

        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Ambil data klaster4 berdasarkan session user ID
        $klaster4 = $klaster4Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        // Cek file ZIP
        $zipFilePath = FCPATH . 'uploads/klaster4/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id ?? $userId,
            'user_id' => $userId,

            // Statistik
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            // Form data
            'klaster4' => $klaster4,
            'existing' => $klaster4 ?? [],
            'status' => $klaster4['status'] ?? null,
            'zipAvailable' => $zipAvailable,
        ];

        return view('pages/operator/klaster4', $data);
    }





    public function klaster5($id = null)
    {
        $session = session();

        // Cek login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster5Model = new \App\Models\Klaster5Model();

        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Ambil data klaster5 berdasarkan user, tahun, dan bulan
        $klaster5 = $klaster5Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        // Cek file ZIP
        $zipFilePath = FCPATH . 'uploads/klaster5/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id ?? $userId,
            'user_id' => $userId,

            // Statistik
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            // Form data
            'klaster5' => $klaster5,
            'existing' => $klaster5 ?? [],
            'status' => $klaster5['status'] ?? null,
            'zipAvailable' => $zipAvailable,
        ];

        return view('pages/operator/klaster5', $data);
    }



    public function tutorial()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
        ];

        return view('pages/operator/tutorial', $data);
    }

    public function index($role = null)
    {
        helper('Klaster');
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        if ($role && $session->get('role') !== $role) {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $klasterModel = new KlasterFormModel();
        $klasters = $klasterModel->findAll();

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'klasters' => $klasters,
        ];

        if ($role === 'operator') {
            return view('pages/operator/dashboard', $data);
        } elseif ($role === 'admin') {
            return view('pages/admin/dashboard', $data);
        } else {
            return redirect()->to('/login');
        }
    }
}