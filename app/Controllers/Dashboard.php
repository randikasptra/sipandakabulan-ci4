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
        $bulan = date('F');

        // Ambil data kelembagaan berdasarkan user_id, tahun, dan bulan
        $kelembagaan = $kelembagaanModel->where('user_id', $id)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        // Cek apakah file ZIP-nya ada
        $zipFilePath = FCPATH . 'uploads/kelembagaan/' . $id . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
            'kelembagaan' => $kelembagaan,
            'zipAvailable' => $zipAvailable,
            'user_id' => $id, // untuk form approval

            // Data untuk kebutuhan statistik
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            // Ini yang dibutuhkan di view:
            'existing' => $kelembagaan ?? [],
            'status' => $kelembagaan['status'] ?? null
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
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster1Model = new \App\Models\Klaster1Model();

        // Ambil data klaster1 berdasarkan user ID
        $klaster1 = $klaster1Model->where('user_id', $id)->first();

        // Cek apakah file ZIP-nya ada
        $zipFilePath = FCPATH . 'uploads/klaster1/' . $id . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
            'klaster1' => $klaster1,
            'zipAvailable' => $zipAvailable,
            'user_id' => $id,
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

            // ✅ Ini yang kamu lupa:
            'status' => $klaster1['status'] ?? null,
            'existing' => $klaster1 ?? []
        ];

        return view('pages/operator/klaster1', $data);
    }



    public function klaster2($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster2Model = new \App\Models\Klaster2Model();

        // Ambil data klaster2 berdasarkan user ID
        $klaster2 = $klaster2Model->where('user_id', $id)->first();

        // Cek apakah file ZIP-nya ada
        $zipFilePath = FCPATH . 'uploads/klaster2/' . $id . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
            'klaster2' => $klaster2,
            'zipAvailable' => $zipAvailable,
            'user_id' => $id,
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),
             'status' => $klaster2['status'] ?? null,
            'existing' => $klaster2 ?? []
        ];

        return view('pages/operator/klaster2', $data);
    }

    public function klaster3($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster3Model = new \App\Models\Klaster3Model();

        // Ambil data klaster3 berdasarkan user ID
        $klaster3 = $klaster3Model->where('user_id', $id)->first();

        // Cek apakah file ZIP-nya ada
        $zipFilePath = FCPATH . 'uploads/klaster3/' . $id . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
            'klaster3' => $klaster3,
            'zipAvailable' => $zipAvailable,
            'user_id' => $id,
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),
        ];

        return view('pages/operator/klaster3', $data);
    }

    public function klaster4($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster4Model = new \App\Models\Klaster4Model();

        // Ambil data klaster4 berdasarkan user ID
        $klaster4 = $klaster4Model->where('user_id', $id)->first();

        // Cek apakah file ZIP-nya ada
        $zipFilePath = FCPATH . 'uploads/klaster4/' . $id . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
            'klaster4' => $klaster4,
            'zipAvailable' => $zipAvailable,
            'user_id' => $id,
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),
        ];

        return view('pages/operator/klaster4', $data);
    }




    public function klaster5($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $klaster5Model = new \App\Models\Klaster5Model();

        // Ambil data klaster5 berdasarkan user ID
        $klaster5 = $klaster5Model->where('user_id', $id)->first();

        // Cek apakah file ZIP-nya tersedia
        $zipFilePath = FCPATH . 'uploads/klaster5/' . $id . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
            'klaster5' => $klaster5,
            'zipAvailable' => $zipAvailable,
            'user_id' => $id,
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),
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