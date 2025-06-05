<?php

namespace App\Controllers;

use App\Models\KlasterFormModel;
use App\Models\UserModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $klasterModel = new KlasterFormModel();
        $klasters = $klasterModel->findAll();

        $data = [
            'user_email' => $session->get('email'),
            'user_role'  => $session->get('role'),
            'username'   => $session->get('username'),
            'klasters'   => $klasters,
            'title'      => 'Dashboard Admin',
        ];

        return view('pages/admin/dashboard', $data); // pastikan file ini ada
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
