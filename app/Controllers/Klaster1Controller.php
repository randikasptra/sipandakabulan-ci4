<?php

namespace App\Controllers;

use App\Models\Klaster1Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;

class Klaster1Controller extends BaseController
{
    protected $klaster1Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster1Model = new Klaster1Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function submit()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

              if ($existing && in_array($existing['status'], ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'Form sudah dikirim atau disetujui. Tidak dapat mengisi ulang.');
        }


        $fields = ['AnakAktaKelahiran', 'anggaran'];
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'status' => 'pending',
        ];

        $totalNilai = 0;

        foreach ($fields as $field) {
            $value = (int) $this->request->getPost($field);
            $data[$field] = $value;
            $totalNilai += $value;

            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return redirect()->back()->with('error', "Ukuran file {$field} melebihi 10MB.");
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', "File {$field} harus berformat ZIP.");
                }

                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/klaster1/', $newName);
                $data["{$field}_file"] = $newName;
            }
        }

        $data['total_nilai'] = $totalNilai;

        $this->klaster1Model->insert($data);

        return redirect()->to('/klaster1/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }

    public function form()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->orderBy('created_at', 'desc')
            ->first();
$data = [
    'user_name' => session()->get('user_name') ?? 'User',
    'user_email' => session()->get('user_email') ?? 'user@example.com',
    'user_role' => session()->get('user_role') ?? 'user',
    'status' => $existing['status'] ?? null,
    'existing' => $existing,
    'nilai_em' => $existing['total_nilai'] ?? 0,
    'nilai_maksimal' => 120,
];


        return view('pages/operator/klaster1', $data);
    }

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        $tahun = $this->request->getPost('tahun');
        $bulan = $this->request->getPost('bulan');
        $catatan = $this->request->getPost('catatan');

        $klaster1 = $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        if (!$klaster1) {
            return redirect()->back()->with('error', 'Data Klaster 1 tidak ditemukan.');
        }

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster1')->first();

        if (!$klasterData) {
            return redirect()->back()->with('error', 'Data klaster tidak ditemukan.');
        }

        $existing = $this->berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterData['id'])
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $dataBerkas = [
            'user_id'     => $userId,
            'klaster'     => $klasterData['id'],
            'tahun'       => $tahun,
            'bulan'       => $bulan,
            'total_nilai' => $klaster1['total_nilai'] ?? 0,
            'status'      => $status,
            'catatan'     => $status === 'rejected' ? $catatan : null,
            'file_path'   => 'klaster1/' . $userId . '.zip'
        ];

        if ($existing) {
            $this->berkasKlasterModel->update($existing['id'], $dataBerkas);
        } else {
            $this->berkasKlasterModel->insert($dataBerkas);
        }

        $this->klaster1Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->set(['status' => $status])
            ->update();

        return redirect()->back()->with('success', 'Status Klaster 1 berhasil diperbarui.');
    }

 public function delete()
{
    $userId = $this->request->getPost('user_id');
    $tahun = $this->request->getPost('tahun');
    $bulan = $this->request->getPost('bulan');

    $existing = $this->klaster1Model
        ->where('user_id', $userId)
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->where('status', 'rejected') // Ganti dari 'pending' ke 'rejected'
        ->first();

    if (!$existing) {
        return redirect()->back()->with('error', 'Data tidak ditemukan atau belum ditolak.');
    }

    // Hapus file upload jika ada
    $fileFields = ['AnakAktaKelahiran_file', 'anggaran_file'];
    foreach ($fileFields as $field) {
        if (!empty($existing[$field])) {
            $filePath = ROOTPATH . 'public/uploads/klaster1/' . $existing[$field];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    // Hapus record klaster1
    $this->klaster1Model->delete($existing['id']);

    // Opsional: Hapus juga dari tabel berkas_klaster (jika ada)
    $klasterFormModel = new KlasterFormModel();
    $klasterData = $klasterFormModel->where('slug', 'klaster1')->first();

    if ($klasterData) {
        $this->berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterData['id'])
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->delete();
    }

    return redirect()->back()->with('success', 'Data Klaster 1 berhasil dihapus permanen.');
}

}
