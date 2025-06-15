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
        $this->userModel = new \App\Models\UserModel(); // untuk ambil data desa
    }

    public function index()
    {
        $data['announcements'] = $this->announcementModel->orderBy('created_at', 'DESC')->findAll();
        return view('pages/admin/pengumuman_list', $data);
    }

    public function create()
    {
        $data['desa_list'] = $this->userModel->distinct()->select('desa')->whereNotIn('desa', [null])->findAll();
        return view('admin/pengumuman_create', $data);
    }

    public function store()
    {
        $this->announcementModel->save([
            'judul'        => $this->request->getPost('judul'),
            'isi'          => $this->request->getPost('isi'),
            'tujuan_desa'  => $this->request->getPost('tujuan_desa') ?: null, // null artinya untuk semua desa
        ]);

        return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil dikirim.');
    }

    public function delete($id)
    {
        $this->announcementModel->delete($id);
        return redirect()->to('/pengumuman')->with('success', 'Pengumuman berhasil dihapus.');
    }
}