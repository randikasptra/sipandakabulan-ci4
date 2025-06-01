<?php

namespace App\Controllers;

use App\Models\KlasterFormModel;

class Dashboard extends BaseController
{

    public function kelembagaan($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Kirim data ke view, misal id saja dulu
        return view('pages/operator/kelembagaan', ['id' => $id]);
    }

    public function klaster1($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Kirim data ke view
        return view('pages/operator/klaster1', ['id' => $id]);
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

        // Panggil model yang kamu buat
        $klasterModel = new KlasterFormModel();

        // Ambil semua data klaster
        $klasters = $klasterModel->findAll();

        $data = [
            'user_email' => $session->get('email'),
            'user_role'  => $session->get('role'),
            'username'   => $session->get('username'),
            'klasters'   => $klasters,  // ini yang nanti di foreach di view
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
