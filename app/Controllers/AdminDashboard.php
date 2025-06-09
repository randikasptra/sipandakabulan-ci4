<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $totalDesa    = $userModel->where('role', 'operator')->countAllResults();
        $sudahInput   = $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults();
        $belumInput   = $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults();
        $perluApprove = $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults();

        $data = [
            'title'        => 'Dashboard Admin',
            'totalDesa'    => $totalDesa,
            'sudahInput'   => $sudahInput,
            'belumInput'   => $belumInput,
            'perluApprove' => $perluApprove,
        ];

        return view('pages/admin/dashboard', $data);
    }

    public function users()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $userModel = new UserModel();
        $users = $userModel->findAll();

        $data = [
            'users' => $users,
            'title' => 'Kelola User',
        ];

        return view('pages/admin/users', $data);
    }

    public function desa()
    {
        return view('pages/admin/desa');
    }

    public function klaster()
    {
        return view('pages/admin/klaster');
    }

    public function approval()
    {
        return view('pages/admin/approval');
    }

    public function laporan()
    {
        return view('pages/admin/laporan');
    }

    public function settings()
    {
        return view('pages/admin/settings');
    }
}
