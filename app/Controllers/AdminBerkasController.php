<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;
use CodeIgniter\Database\BaseBuilder;

class AdminBerkasController extends BaseController
{
  public function index()
{
    $db = \Config\Database::connect();

    $data['berkas'] = $db->table('berkas_klaster')
        ->select('berkas_klaster.*, users.desa, klasters.title as nama_klaster')
        ->join('users', 'users.id = berkas_klaster.user_id')
        ->join('klasters', 'klasters.id = berkas_klaster.klaster') // JOIN ke klasters
        ->orderBy('berkas_klaster.created_at', 'DESC')
        ->get()
        ->getResultArray();

    return view('pages/admin/berkas', $data);
}

   public function review($klaster)
{
    $db = \Config\Database::connect();

    $data['berkas'] = $db->table('berkas_klaster')
        ->select('berkas_klaster.*, users.desa, klasters.title as nama_klaster')
        ->join('users', 'users.id = berkas_klaster.user_id')
        ->join('klasters', 'klasters.id = berkas_klaster.klaster') // JOIN ke klasters
        ->where('berkas_klaster.klaster', $klaster)
        ->orderBy('berkas_klaster.created_at', 'DESC')
        ->get()
        ->getResultArray();

    $data['klaster'] = $klaster;

    return view('pages/admin/review_kelembagaan', $data);
}

    public function updateStatus()
    {
        $berkasModel = new BerkasKlasterModel();

        $id = $this->request->getPost('berkas_id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $data = [
            'status' => $status,
            'catatan' => ($status === 'rejected') ? $catatan : null,
        ];

        $berkasModel->update($id, $data);

        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui.');
    }

   public function store()
{
    $berkasModel = new BerkasKlasterModel();
    $klasterSlug = $this->request->getPost('klaster');

    // Ambil ID klaster dari slug
    $klasterRow = (new \App\Models\KlasterFormModel())
        ->where('slug', $klasterSlug)
        ->first();

    if (!$klasterRow) {
        return redirect()->back()->with('error', 'Klaster tidak ditemukan.');
    }

    $data = [
        'user_id' => $this->request->getPost('user_id'),
        'klaster' => $klasterRow['id'], // << Ganti ke id klaster
        'status' => $this->request->getPost('status'),
        'total_nilai' => $this->request->getPost('total_nilai'),
        'tahun' => $this->request->getPost('tahun'),
        'bulan' => $this->request->getPost('bulan'),
        'catatan' => $this->request->getPost('catatan'),
    ];

    // Cek apakah sudah ada entry
    $existing = $berkasModel->where('user_id', $data['user_id'])
        ->where('klaster', $data['klaster'])
        ->first();

    if ($existing) {
        $berkasModel->update($existing['id'], $data);
    } else {
        $berkasModel->insert($data);
    }

    return redirect()->back()->with('success', 'Status berhasil disimpan ke laporan berkas.');
}
}