<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminDashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        $totalDesa = $userModel->where('role', 'operator')->countAllResults();
        $sudahInput = $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults();
        $belumInput = $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults();
        $perluApprove = $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults();

        $data = [
            'title' => 'Dashboard Admin',
            'totalDesa' => $totalDesa,
            'sudahInput' => $sudahInput,
            'belumInput' => $belumInput,
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

    // ⬇ Tambahkan ini
    public function storeUser()
    {
        $userModel = new \App\Models\UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'desa' => $this->request->getPost('desa'), // <- TAMBAHKAN INI
            'status_input' => 'belum',
            'status_approve' => 'pending',
        ];

        $userModel->save($data);

        return redirect()->to('/dashboard/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function desa()
    {
        return view('pages/admin/desa');
    }

    public function approval()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $userModel = new UserModel();

        $desasPendingApproval = $userModel->where('role', 'operator')
            ->where('status_input', 'sudah')
            ->where('status_approve', 'pending')
            ->findAll();

        $data = [
            'title' => 'Approval Data Desa',
            'desas' => $desasPendingApproval,
        ];

        return view('pages/admin/approval', $data);
    }

    public function approveDesa($userId)
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $userModel = new UserModel();
        $userModel->update($userId, ['status_approve' => 'approved']);

        return redirect()->to('/admin/approval')->with('success', 'Data desa berhasil di-approve.');
    }

    public function rejectDesa($userId)
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('errors', ['Akses tidak diizinkan']);
        }

        $userModel = new UserModel();
        $userModel->update($userId, ['status_approve' => 'rejected']);

        return redirect()->to('/admin/approval')->with('success', 'Data desa berhasil ditolak.');
    }

    public function laporan()
    {
        return view('pages/admin/laporan');
    }

    public function approveList()
    {
        $userModel = new \App\Models\UserModel(); // Ganti dengan model sesuai struktur kamu
        $data['users'] = $userModel->findAll();   // Atau filter sesuai kebutuhan
        return view('pages/admin/approve_list', $data);
    }

    public function settings()
    {
        return view('pages/admin/settings');
    }
}