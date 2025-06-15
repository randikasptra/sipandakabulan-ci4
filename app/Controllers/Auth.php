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
    $session = session();
    $userModel = new \App\Models\UserModel();

    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $user = $userModel->where('email', $email)->first();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Simpan semua data penting ke session termasuk 'desa'
            $sessionData = [
                'id'       => $user['id'],
                'username' => $user['username'],
                'email'    => $user['email'],
                'role'     => $user['role'],
                'desa'     => $user['desa'], // ✅ ini bagian penting
                'logged_in'=> true
            ];
            $session->set($sessionData);

            return redirect()->to('/dashboard/' . $user['role']);
        } else {
            return redirect()->back()->with('error', 'Password salah');
        }
    } else {
        return redirect()->back()->with('error', 'Email tidak ditemukan');
    }
}


    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
