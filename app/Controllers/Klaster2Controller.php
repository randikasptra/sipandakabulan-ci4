<?php

namespace App\Controllers;

use App\Models\Klaster2Model;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;

class Klaster2Controller extends BaseController
{
    protected $klaster2Model;
    protected $berkasKlasterModel;

    public function __construct()
    {
        $this->klaster2Model = new Klaster2Model();
        $this->berkasKlasterModel = new BerkasKlasterModel();
    }

 public function submit()
{
    $userId = session()->get('id');
    $tahun = date('Y');
    $bulan = date('F');

    // Cek apakah data sudah ada dan statusnya tidak bisa input ulang
    $existing = $this->klaster2Model
        ->where('user_id', $userId)
        ->where('tahun', $tahun)
        ->where('bulan', $bulan)
        ->first();

    if ($existing && in_array($existing['status'], ['pending', 'approved'])) {
        return redirect()->back()->with('error', 'Form sudah dikirim atau disetujui. Tidak dapat mengisi ulang.');
    }

    // Ambil nilai indikator
    $perkawinanAnak = (int) $this->request->getPost('perkawinanAnak');
    $pencegahanPernikahan = (int) $this->request->getPost('pencegahanPernikahan');
    $lembagaKonsultasi = (int) $this->request->getPost('lembagaKonsultasi');

    // Hitung total nilai
    $total_nilai = $perkawinanAnak + $pencegahanPernikahan + $lembagaKonsultasi;

    // Susun data awal
    $data = [
        'user_id' => $userId,
        'tahun' => $tahun,
        'bulan' => $bulan,
        'perkawinanAnak' => $perkawinanAnak,
        'pencegahanPernikahan' => $pencegahanPernikahan,
        'lembagaKonsultasi' => $lembagaKonsultasi,
        'total_nilai' => $total_nilai,
        'status' => 'pending',
    ];

    // Upload file masing-masing indikator
    $fields = ['perkawinanAnak', 'pencegahanPernikahan', 'lembagaKonsultasi'];

    foreach ($fields as $field) {
        $file = $this->request->getFile("{$field}_file");

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() > 10 * 1024 * 1024) {
                return redirect()->back()->with('error', "Ukuran file $field terlalu besar. Maksimum 10MB.");
            }

            if ($file->getExtension() !== 'zip') {
                return redirect()->back()->with('error', "File $field harus berformat ZIP.");
            }

            $newName = $field . '_' . time() . '_' . $file->getClientName();
            $file->move(ROOTPATH . 'public/uploads/klaster2/', $newName);
            $data["{$field}_file"] = $newName;
        } else {
            $data["{$field}_file"] = null;
        }
    }

    // Simpan data
    if ($existing && $existing['status'] === 'rejected') {
        $this->klaster2Model->update($existing['id'], $data);
    } else {
        $this->klaster2Model->insert($data);
    }

    return redirect()->to('/klaster2/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
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
            'nilai_maksimal' => 180, // Total dari 3 indikator (misal)
        ];

        return view('pages/operator/klaster2', $data);
    }

    public function approve()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status'); // approved atau rejected
        $catatan = $this->request->getPost('catatan');

        $klasterFormModel = new KlasterFormModel();

        $klaster2 = $this->klaster2Model
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$klaster2) {
            return redirect()->back()->with('error', 'Data Klaster 2 tidak ditemukan.');
        }

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
            'catatan' => ($status === 'rejected') ? $catatan : null,
            'file_path' => 'klaster2/' . $userId . '.zip',
            
        ];

        $existingBerkas = $this->berkasKlasterModel
            ->where('user_id', $userId)
            ->where('klaster', $klasterMeta['id'])
            ->first();

        if ($existingBerkas) {
            $this->berkasKlasterModel->update($existingBerkas['id'], $dataBerkas);
        } else {
            $this->berkasKlasterModel->insert($dataBerkas);
        }

        $this->klaster2Model
            ->where('user_id', $userId)
            ->set(['status' => $status])
            ->update();

        return redirect()->back()->with('success', 'Status Klaster 2 berhasil diperbarui dan disimpan ke laporan.');
    }
}
