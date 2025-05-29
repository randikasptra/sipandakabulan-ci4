<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function showLogin()
    {
        if (session()->get('logged_in')) {
            // Kalau sudah login, langsung redirect ke dashboard
            return redirect()->to('/dashboard/' . session()->get('role'));
        }

        // Kalau belum login, tampilkan form login tanpa destroy session
        return view('auth/login');
    }


    public function login()
    {
        $userModel = new UserModel();
        $identifier = $this->request->getPost('email') ?? $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        // Coba cari user berdasarkan email dulu, kalau tidak ada pakai username
        $user = $userModel->where('email', $identifier)->orWhere('username', $identifier)->first();

        if ($user && password_verify($password, $user['password'])) {
            if ($role && $user['role'] !== $role) {
                return redirect()->back()->withInput()->with('errors', ['Role tidak sesuai.']);
            }

            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);

            return redirect()->to('/dashboard/' . $user['role']);
        }

        return redirect()->back()->withInput()->with('errors', ['Email/Username, password, atau hak akses salah.']);
    }

    
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
