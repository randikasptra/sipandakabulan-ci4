<?php

namespace App\Controllers;

use App\Models\{KlasterFormModel, KelembagaanModel, Klaster1Model, Klaster2Model, Klaster3Model, Klaster4Model, Klaster5Model, UserModel, AnnouncementModel};

class Dashboard extends BaseController
{
    protected $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
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

    $nilaiEm = $kelembagaan['total_nilai'] ?? 0;
    $nilaiMaksimal = 220;
    $progres = ($nilaiMaksimal > 0) ? round(($nilaiEm / $nilaiMaksimal) * 100) : 0;

    // Ambil semua klaster
    $klasterModel = new KlasterFormModel();
    $klasters = $klasterModel->findAll();

    // Inject nilai dari masing-masing model
    foreach ($klasters as &$klaster) {
        $slug = $klaster['slug'];
        $klaster['nilai_em'] = 0;
        $klaster['nilai_maksimal'] = 100;

        switch ($slug) {
            case 'kelembagaan':
                $klaster['nilai_em'] = $kelembagaan['total_nilai'] ?? 0;
                $klaster['nilai_maksimal'] = 220;
                break;
            case 'klaster1':
                $model = new Klaster1Model();
                $data = $model->where('user_id', $userId)->where('tahun', $tahun)->where('bulan', $bulan)->first();
                $klaster['nilai_em'] = $data['total_nilai'] ?? 0;
                $klaster['nilai_maksimal'] = 120;
                break;
            case 'klaster2':
                $model = new Klaster2Model();
                $data = $model->where('user_id', $userId)->where('tahun', $tahun)->where('bulan', $bulan)->first();
                $klaster['nilai_em'] = $data['total_nilai'] ?? 0;
                $klaster['nilai_maksimal'] = 100;
                break;
            case 'klaster3':
                $model = new Klaster3Model();
                $data = $model->where('user_id', $userId)->where('tahun', $tahun)->where('bulan', $bulan)->first();
                $klaster['nilai_em'] = $data['total_nilai'] ?? 0;
                $klaster['nilai_maksimal'] = 180;
                break;
            case 'klaster4':
                $model = new Klaster4Model();
                $data = $model->where('user_id', $userId)->where('tahun', $tahun)->where('bulan', $bulan)->first();
                $klaster['nilai_em'] = $data['total_nilai'] ?? 0;
                $klaster['nilai_maksimal'] = 270;
                break;
            case 'klaster5':
                $model = new Klaster5Model();
                $data = $model->where('user_id', $userId)->where('tahun', $tahun)->where('bulan', $bulan)->first();
                $klaster['nilai_em'] = $data['total_nilai'] ?? 0;
                $klaster['nilai_maksimal'] = 130;
                break;
        }
    }

    $data = [
            'title' => 'Dashboard SIPANDAKABULAN',

        'user_email' => $session->get('email'),
        'user_role' => $session->get('role'),
        'username' => $session->get('username'),
        'klasters' => $klasters,
        'nilaiEm' => $nilaiEm,
        'nilaiMaksimal' => $nilaiMaksimal,
        'progres' => $progres,
        'user_id' => $userId, // Buat kebutuhan card
    ];

    if ($role === 'operator') {
        return view('pages/operator/dashboard', $data);
    } elseif ($role === 'admin') {
        return view('pages/admin/dashboard', $data);
    } else {
        return redirect()->to('/login');
    }
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
            ->orWhere('tujuan_desa IS NULL', null, false)
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

  public function ubahPassword()
{
    $session = session();
    $userId = $session->get('id');

    $current = $this->request->getPost('current_password');
    $new = $this->request->getPost('new_password');
    $confirm = $this->request->getPost('confirm_password');

    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($userId);

    // Validasi password lama
    if (!$user || !password_verify($current, $user['password'])) {
        return redirect()->back()->with('error', 'Password lama tidak cocok.');
    }

    // Validasi konfirmasi
    if ($new !== $confirm) {
        return redirect()->back()->with('error', 'Konfirmasi password tidak sesuai.');
    }

    // Update password
    $userModel->update($userId, [
        'password' => password_hash($new, PASSWORD_DEFAULT),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    return redirect()->back()->with('success', 'Password berhasil diubah.');
}


public function updatePassword($id)
{
    $userModel = new \App\Models\UserModel();

    $password = $this->request->getPost('password');
    $confirm = $this->request->getPost('confirm_password');

    // Validasi kosong
    if (empty($password) || empty($confirm)) {
        return redirect()->back()->with('error', 'Password dan konfirmasi harus diisi.');
    }

    // Validasi cocok
    if ($password !== $confirm) {
        return redirect()->back()->with('error', 'Konfirmasi password tidak sesuai.');
    }

    // Update
    $userModel->update($id, [
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);

    return redirect()->back()->with('success', 'Password berhasil diperbarui.');
}



}
