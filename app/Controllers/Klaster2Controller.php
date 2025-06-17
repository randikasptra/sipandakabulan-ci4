<?php

namespace App\Controllers;

use App\Models\Klaster2Model;

class Klaster2Controller extends BaseController
{
    public function submit()
    {
        $model = new Klaster2Model();
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        // Cek apakah sudah mengisi untuk bulan dan tahun ini
        $existing = $model->where('user_id', $userId)
                          ->where('tahun', $tahun)
                          ->where('bulan', $bulan)
                          ->whereIn('status', ['pending', 'approved'])
                          ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Kamu sudah mengisi form untuk bulan ini dan sedang menunggu atau sudah disetujui.');
        }

        // Ambil nilai input
        $data = [
            'user_id' => $userId,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'perkawinanAnak' => (int) $this->request->getPost('perkawinanAnak'),
            'pencegahanPernikahan' => (int) $this->request->getPost('pencegahanPernikahan'),
            'lembagaKonsultasi' => (int) $this->request->getPost('lembagaKonsultasi'),
        ];

        // Proses upload file
        $fields = ['perkawinanAnak', 'pencegahanPernikahan', 'lembagaKonsultasi'];
        foreach ($fields as $field) {
            $file = $this->request->getFile("{$field}_file");

            if ($file && $file->isValid() && !$file->hasMoved()) {
                if ($file->getSize() > 1024 * 1024 * 1024) {
                    return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimum 1GB.');
                }

                if ($file->getExtension() !== 'zip') {
                    return redirect()->back()->with('error', 'File ' . $field . ' harus berformat ZIP.');
                }

                $newName = $field . '_' . time() . '_' . $file->getClientName();
                $file->move(ROOTPATH . 'public/uploads/klaster2/', $newName);
                $data["{$field}_file"] = $newName;
            }
        }

        // Tambahkan status
        $data['status'] = 'pending';

        $model->save($data);

        return redirect()->to('/klaster2/form')->with('success', 'Data berhasil disimpan dan menunggu persetujuan admin.');
    }

    public function form()
    {
        $model = new Klaster2Model();
        $userId = session()->get('id');
        $tahun = date('Y');
        $bulan = date('F');

        $existing = $model->where('user_id', $userId)
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
        ];

        return view('pages/operator/klaster2', $data);
    }
}
