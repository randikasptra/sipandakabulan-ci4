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

    // Ambil data berkas yang disetujui
    $berkas = $db->table('berkas_klaster')
        ->select('berkas_klaster.*, users.desa, klasters.title as nama_klaster')
        ->join('users', 'users.id = berkas_klaster.user_id')
        ->join('klasters', 'klasters.id = berkas_klaster.klaster')
        ->where('berkas_klaster.status', 'approved')
        ->orderBy('berkas_klaster.created_at', 'DESC')
        ->get()
        ->getResultArray();

    // Hitung jumlah laporan per klaster (untuk Chart)
    $jumlahPerKlaster = [];
    foreach ($berkas as $b) {
        $namaKlaster = $b['nama_klaster'];
        if (!isset($jumlahPerKlaster[$namaKlaster])) {
            $jumlahPerKlaster[$namaKlaster] = 0;
        }
        $jumlahPerKlaster[$namaKlaster]++;
    }

    $data = [
        'title' => 'Laporan Berkas Disetujui',
        'berkas' => $berkas,
        'chart_data' => json_encode($jumlahPerKlaster),
    ];

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
        $kelembagaanModel = new \App\Models\KelembagaanModel();

        $id = $this->request->getPost('berkas_id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        // ✅ Update berkas_klaster
        $berkasModel->update($id, [
            'status' => $status,
            'catatan' => ($status === 'rejected') ? $catatan : null,
        ]);

        // ✅ Ambil berkas setelah update
        $berkas = $berkasModel->find($id);

        // ✅ Hanya update kelembagaan kalau klaster = 1
        if ($berkas && $berkas['klaster'] == 1) {
            $kelembagaan = $kelembagaanModel
                ->where('user_id', $berkas['user_id'])
                ->where('tahun', $berkas['tahun'])
                ->where('bulan', $berkas['bulan'])
                ->first();

            if ($kelembagaan) {
                $kelembagaanModel
                    ->where('id', $kelembagaan['id']) // lebih aman pakai ID langsung
                    ->set(['status' => $status])
                    ->update();
            } else {
                // Debug kalau tidak ketemu
                log_message('error', 'Kelembagaan tidak ditemukan untuk user_id: ' . $berkas['user_id']);
            }
        }

        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui.');
    }



    public function store()
    {
        $berkasModel = new BerkasKlasterModel();
        $kelembagaanModel = new \App\Models\KelembagaanModel();
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
            'klaster' => $klasterRow['id'],
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

        // 🔁 Jika klaster adalah kelembagaan (id = 1), update juga tabel kelembagaan
        if ($data['klaster'] == 1) {
            $kelembagaan = $kelembagaanModel
                ->where('user_id', $data['user_id'])
                ->where('tahun', $data['tahun'])
                ->where('bulan', $data['bulan']) // Pastikan format bulan cocok!
                ->first();

            if ($kelembagaan) {
                $kelembagaanModel->update($kelembagaan['id'], [
                    'status' => $data['status']
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status berhasil disimpan ke laporan berkas.');
    }

}