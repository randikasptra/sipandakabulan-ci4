<?php

namespace App\Controllers;

use App\Models\Klaster2Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;
use App\Models\UserModel;

class Klaster2Controller extends BaseController
{
    protected $klaster2Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster2Model = new Klaster2Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

    public function klaster2($id = null)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $userId = $session->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $klaster2 = $this->klaster2Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $zipFilePath = FCPATH . 'uploads/klaster2/' . ($id ?? $userId) . '.zip';
        $zipAvailable = file_exists($zipFilePath);

        $data = [
            'user_email' => $session->get('email'),
            'user_role' => $session->get('role'),
            'username' => $session->get('username'),
            'id' => $id ?? $userId,
            'user_id' => $userId,
            'klaster2' => $klaster2,
            'zipAvailable' => $zipAvailable,
            'existing' => $klaster2 ?? [],
            'status' => $klaster2['status'] ?? null,
            'nilai_em' => $klaster2['total_nilai'] ?? 0,
            'nilai_maksimal' => 100,
            'totalDesa' => $userModel->where('role', 'operator')->countAllResults(),
            'sudahInput' => $userModel->where(['role' => 'operator', 'status_input' => 'sudah'])->countAllResults(),
            'belumInput' => $userModel->where(['role' => 'operator', 'status_input' => 'belum'])->countAllResults(),
            'perluApprove' => $userModel->where(['role' => 'operator', 'status_approve' => 'pending'])->countAllResults(),
        ];

        return view('pages/operator/klaster2', $data);
    }

    public function submit()
{
    $userId = session()->get('id');
    $tahun = date('Y');
    $bulan = date('F');

    $existing = $this->klaster2Model
        ->where('user_id', $userId)
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->first();

    if ($existing && in_array($existing['status'], ['pending', 'approved'])) {
        return redirect()->back()->with('error', 'Form sudah dikirim atau disetujui. Tidak dapat mengisi ulang.');
    }

    $fields = ['perkawinanAnak', 'pencegahanPernikahan', 'lembagaKonsultasi'];
    $totalNilai = 0;
    $data = [
        'user_id' => $userId,
        'tahun' => $tahun,
        'bulan' => $bulan,
        'status' => 'pending'
    ];

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
            $file->move(ROOTPATH . 'public/uploads/klaster2/', $newName);
            $data["{$field}_file"] = $newName;
        }
    }

    $data['total_nilai'] = $totalNilai;

    try {
        if ($existing && $existing['status'] === 'rejected') {
            $this->klaster2Model->update($existing['id'], $data);
        } else {
            $this->klaster2Model->insert($data);
        }

        return redirect()->to('/klaster2/form')->with('success', 'Data berhasil dikirim. Menunggu persetujuan admin.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    }
}


    public function form()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster2Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->orderBy('created_at', 'desc')
            ->first();

        $data = [
            'user_name' => session()->get('user_name'),
            'user_email' => session()->get('user_email'),
            'user_role' => session()->get('user_role'),
            'status' => $existing['status'] ?? null,
            'existing' => $existing ?? null,
            'nilai_em' => $existing['total_nilai'] ?? 0,
            'nilai_maksimal' => 100,
        ];

        return view('pages/operator/klaster2', $data);
    }

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $klaster2 = $this->klaster2Model
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$klaster2) {
            return redirect()->back()->with('error', 'Data Klaster 2 tidak ditemukan.');
        }

        $klasterFormModel = new KlasterFormModel();
        $klasterMeta = $klasterFormModel->where('slug', 'klaster2')->first();

        if (!$klasterMeta) {
            return redirect()->back()->with('error', 'Metadata Klaster tidak ditemukan.');
        }

        $dataBerkas = [
            'user_id' => $userId,
            'klaster' => $klasterMeta['id'],
            'tahun' => $klaster2['tahun'],
            'bulan' => $klaster2['bulan'],
            'total_nilai' => $klaster2['total_nilai'] ?? 0,
            'status' => $status,
            'catatan' => $status === 'rejected' ? $catatan : null,
            'file_path' => 'klaster2/' . $userId . '.zip'
        ];

        $existingBerkas = $this->berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterMeta['id'])
            ->where('tahun', $klaster2['tahun'])
            ->where('bulan', $klaster2['bulan'])
            ->first();

        if ($existingBerkas) {
            $this->berkasKlasterModel->update($existingBerkas['id'], $dataBerkas);
        } else {
            $this->berkasKlasterModel->insert($dataBerkas);
        }

        $this->klaster2Model
            ->where('user_id', $userId)
            ->where('tahun', $klaster2['tahun'])
            ->where('bulan', $klaster2['bulan'])
            ->set(['status' => $status])
            ->update();

      $userId = $this->request->getPost('user_id');
          if ($status === 'rejected') {
            return redirect()->to('dashboard/admin/approve/' . $userId)->with('success', 'Status berhasil di Tolak.');
        }
        return redirect()->to('dashboard/berkas')->with('success', 'Berkas di Setujui.');

    }

    public function batal()
    {
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster2Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Tidak ada data yang bisa dibatalkan.');
        }

        $fields = ['perkawinanAnak_file', 'pencegahanPernikahan_file', 'lembagaKonsultasi_file'];
        foreach ($fields as $fileField) {
            if (!empty($existing[$fileField])) {
                $filePath = ROOTPATH . 'public/uploads/klaster2/' . $existing[$fileField];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $this->klaster2Model->delete($existing['id']);

        return redirect()->to('/klaster2/form')->with('success', 'Pengiriman data dibatalkan. Silakan isi ulang formulir.');
    }

    public function delete()
    {
        $userId = $this->request->getPost('user_id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $this->klaster2Model
            ->where('user_id', $userId)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'rejected')
            ->first();

        if (!$existing) {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau belum ditolak.');
        }

        $fields = ['perkawinanAnak_file', 'pencegahanPernikahan_file', 'lembagaKonsultasi_file'];
        foreach ($fields as $fileField) {
            if (!empty($existing[$fileField])) {
                $filePath = ROOTPATH . 'public/uploads/klaster2/' . $existing[$fileField];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $this->klaster2Model->delete($existing['id']);

        $klasterFormModel = new KlasterFormModel();
        $klasterData = $klasterFormModel->where('slug', 'klaster2')->first();

        if ($klasterData) {
            $this->berkasKlasterModel
                ->where('user_id', $userId)
                ->where('klaster', $klasterData['id'])
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->delete();
        }

        return redirect()->back()->with('success', 'Data Klaster 2 berhasil dihapus.');
    }
}
