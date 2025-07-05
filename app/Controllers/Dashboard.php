<?php

namespace App\Controllers;

use App\Models\KlasterFormModel;
use App\Models\KelembagaanModel;
use App\Models\Klaster1Model;
use App\Models\Klaster2Model;
use App\Models\Klaster3Model;
use App\Models\Klaster4Model;
use App\Models\Klaster5Model;
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
    $bulan = date('F'); // Sama dengan saat submit()

    $kelembagaan = $kelembagaanModel
        ->where('user_id', session()->get('id'))
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->first();

    $zipFilePath = FCPATH . 'uploads/kelembagaan/' . $id . '.zip';
    $zipAvailable = file_exists($zipFilePath);

    // Default nilai EM & maksimal
    $nilaiEm = $kelembagaan['total_nilai'] ?? 0;
    $nilaiMaksimal = 220; // Kalau mau dinamis, hitung dari total skor maksimal tiap indikator

    $data = [
        'user_email' => $session->get('email'),
        'user_role' => $session->get('role'),
        'user_name' => $session->get('username'),
        'id' => $id,
        'kelembagaan' => $kelembagaan,
        'zipAvailable' => $zipAvailable,
        'user_id' => $id,

        'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
        'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
        'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
        'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),

        // penting untuk form
        'existing' => $kelembagaan ?? [],
        'status' => $kelembagaan['status'] ?? null,

        // tambahan penting untuk progress
        'nilai_em' => $nilaiEm,
        'nilai_maksimal' => $nilaiMaksimal,
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
            'title' => 'Pengumuman',
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'pengumuman' => $pengumuman
        ];

        return view('pages/operator/pengumuman_user', $data);
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
            'title' => 'Tutorial',
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

        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Ambil data kelembagaan
        $kelembagaanModel = new KelembagaanModel();
        $kelembagaan = $kelembagaanModel
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        // Hitung nilai dan progresnya
        $nilaiEm = $kelembagaan['total_nilai'] ?? 0;
        $nilaiMaksimal = 220;
        $progres = ($nilaiMaksimal > 0) ? round(($nilaiEm / $nilaiMaksimal) * 100) : 0;

        // Ambil semua klaster untuk ditampilkan
        $klasterModel = new KlasterFormModel();
        $klasters = $klasterModel->findAll();

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'klasters' => $klasters,
            'nilaiEm' => $nilaiEm,
            'nilaiMaksimal' => $nilaiMaksimal,
            'progres' => $progres,
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