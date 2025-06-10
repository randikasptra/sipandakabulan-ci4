<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelembagaanModel;

class ApprovalController extends BaseController
{

    public function index()
{
    $model = new KelembagaanModel();

    $builder = $model->builder();
    $builder->select('kelembagaan_forms.*, users.username, users.email, users.id as user_id');
    $builder->join('users', 'users.id = kelembagaan_forms.user_id');
    $kelembagaanData = $builder->get()->getResultArray();

    $desas = [];
    foreach ($kelembagaanData as $item) {
        $desas[] = [
            'id'             => $item['id'],
            'username'       => $item['username'],
            'email'          => $item['email'],
            'status_input'   => 'lengkap',
            'status_approve' => $item['status'],
            'submit_date'    => $item['created_at'],
        ];
    }

    return view('pages/admin/approval', [
        'title' => 'Approval Data Desa',
        'desas' => $desas,
    ]);
}

public function approve($id)
{
    $model = new KelembagaanModel();
    $model->update($id, ['status' => 'approved']);

    return redirect()->back()->with('success', 'Data desa berhasil di-approve.');
}

public function proses($id)
{
    $model = new KelembagaanModel();

    // Ambil data lengkap kelembagaan termasuk klaster (misalnya simpan di 1 tabel atau relasi)
    $dataDesa = $model->find($id);

    if (!$dataDesa) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data tidak ditemukan');
    }

    // Misal file klaster disimpan dalam kolom: klaster1_file, klaster2_file, dst
    $klasterFiles = [
        'Klaster 1' => $dataDesa['klaster1_file'] ?? null,
        'Klaster 2' => $dataDesa['klaster2_file'] ?? null,
        'Klaster 3' => $dataDesa['klaster3_file'] ?? null,
        'Klaster 4' => $dataDesa['klaster4_file'] ?? null,
        'Klaster 5' => $dataDesa['klaster5_file'] ?? null,
    ];

    return view('admin/approval_proses', [
        'title' => 'Detail Data Klaster',
        'desa' => $dataDesa,
        'klasterFiles' => $klasterFiles,
    ]);
}

public function reject($id)
{
    $model = new KelembagaanModel();
    $model->update($id, ['status' => 'rejected']);

    return redirect()->back()->with('success', 'Data desa berhasil ditolak.');
}



    public function getData()
    {
        $model = new KelembagaanModel();

        $builder = $model->builder();
        $builder->select('kelembagaan_forms.*, users.username, users.email, users.id as user_id');
        $builder->join('users', 'users.id = kelembagaan_forms.user_id');
        $kelembagaanData = $builder->get()->getResultArray();

        $desas = [];
        foreach ($kelembagaanData as $item) {
            $desas[] = [
                'id'             => $item['id'],
                'username'       => $item['username'],
                'email'          => $item['email'],
                'status_input'   => $item['status'],   // status pengisian data
                'status_approve' => $item['status'],   // status approval
                // bisa tambah field lain sesuai kebutuhan
            ];
        }

        return $this->response->setJSON($desas);
    }
}
