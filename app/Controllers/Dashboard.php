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

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),
        ];

        return view('pages/operator/kelembagaan', $data);
    }

    public function pengumuman_user()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $desa_operator = $session->get('desa');

        $pengumuman = $this->announcementModel
            ->groupStart()
            ->where('tujuan_desa', $desa_operator)
            ->orWhere('tujuan_desa', 'semua')
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

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id,
        ];

        return view('pages/operator/klaster1', $data);
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