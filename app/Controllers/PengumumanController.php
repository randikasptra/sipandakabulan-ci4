<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;
use App\Models\UserModel;

class PengumumanController extends BaseController
{
    protected $announcementModel;
    protected $userModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['announcements'] = $this->announcementModel->orderBy('created_at', 'DESC')->findAll();

        // Kirim desa_list ke view
        $data['desa_list'] = $this->userModel
            ->select('desa')
            ->where('desa IS NOT NULL')
            ->groupBy('desa')
            ->findAll();

        return view('pages/admin/pengumuman_list', $data);
    }

    public function create()
    {
        $data['desa_list'] = $this->userModel
            ->select('desa')
            ->where('desa IS NOT NULL')
            ->groupBy('desa')
            ->findAll();

        return view('pages/admin/pengumuman_list', $data);
    }

    public function store()
    {
        $data = [
            'judul'        => $this->request->getPost('judul'),
            'isi'          => $this->request->getPost('isi'),
            'tujuan_desa'  => $this->request->getPost('tujuan_desa') ?: null, // null = semua desa
        ];

        if ($this->announcementModel->save($data)) {
            return redirect()->to('/dashboard/pengumuman_list')->with('success', 'Pengumuman berhasil dikirim.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan pengumuman.');
        }
    }

    public function delete($id)
    {
        $this->announcementModel->delete($id);
        return redirect()->to('/dashboard/pengumuman_list')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
