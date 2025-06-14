<?php
namespace App\Controllers;

use App\Models\KelembagaanModel;

class KelembagaanController extends BaseController
{
    public function formKelembagaan()
    {
        $klaster = [
            [
                'judul' => '1. Adanya Peraturan yang mencakup lima klaster',
                'nama' => 'peraturan',
                'nilai' => 60,
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => 'Ada 1 SK',
                    30 => 'Ada 2–3 SK',
                    45 => 'Ada 4 SK',
                    60 => 'Ada ≥5 SK'
                ],
                'file' => 'peraturan.xlsx'
            ],
            [
                'judul' => '2. Adanya Anggaran Responsif Anak',
                'nama' => 'anggaran',
                'nilai' => 50,
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => '≤5%',
                    20 => '6–10%',
                    35 => '11–20%',
                    50 => '≥30%'
                ],
                'file' => 'anggaran.xlsx'
            ],
            [
                'judul' => '3. Ada Forum Anak Desa',
                'nama' => 'forum_anak',
                'nilai' => 40,
                'opsi' => [
                    0 => 'Tidak ada',
                    13 => 'Ada tapi tidak aktif',
                    26 => 'Ada, aktif sesekali',
                    40 => 'Ada dan aktif rutin'
                ],
                'file' => ''
            ],
            [
                'judul' => '4. Ada Data Terpilah mencakup 5 klaster',
                'nama' => 'data_terpilah',
                'nilai' => 50,
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => '1 Klaster',
                    30 => '2–3 Klaster',
                    40 => '4 Klaster',
                    50 => '5 Klaster'
                ],
                'file' => 'data_terpilah.xlsx'
            ],
            [
                'judul' => '5. Adakah dunia usaha yang terlibat dalam pemenuhan hak anak',
                'nama' => 'dunia_usaha',
                'nilai' => 20,
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => '1–2 usaha',
                    15 => '3 usaha',
                    20 => '≥4 usaha'
                ],
                'file' => 'dunia_usaha.xlsx'
            ]
        ];

        return view('pages/operator/kelembagaan', ['klaster' => $klaster]);
    }

    public function submitKelembagaan()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $rules = [
            'peraturan' => 'required|numeric',
            'anggaran' => 'required|numeric',
            'forum_anak' => 'required|numeric',
            'data_terpilah' => 'required|numeric',
            'dunia_usaha' => 'required|numeric',

            'peraturan_file' => 'if_exist|ext_in[zip]',
            'anggaran_file' => 'if_exist|ext_in[zip]',
            'forum_anak_file' => 'if_exist|ext_in[zip]',
            'data_terpilah_file' => 'if_exist|ext_in[zip]',
            'dunia_usaha_file' => 'if_exist|ext_in[zip]',

        ];


        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Pastikan nilai angka dan file valid.');
        }

        $model = new KelembagaanModel();

        $data = [
            'user_id' => session('user_id'),
            'tahun' => date('Y'),
            'peraturan_value' => $this->request->getPost('peraturan') ?? 0,
            'anggaran_value' => $this->request->getPost('anggaran') ?? 0,
            'forum_anak_value' => $this->request->getPost('forum_anak') ?? 0,
            'data_terpilah_value' => $this->request->getPost('data_terpilah') ?? 0,
            'dunia_usaha_value' => $this->request->getPost('dunia_usaha') ?? 0,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $data['total_nilai'] = $data['peraturan_value'] + $data['anggaran_value'] +
            $data['forum_anak_value'] + $data['data_terpilah_value'] +
            $data['dunia_usaha_value'];

        // Buat folder upload jika belum ada
        $uploadPath = WRITEPATH . 'uploads/kelembagaan/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Upload file jika ada
        $fileFields = ['peraturan_file', 'anggaran_file', 'forum_anak_file', 'data_terpilah_file', 'dunia_usaha_file'];

        foreach ($fileFields as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);
                $data[$field] = $newName;
            }
        }

        $model->insert($data);

        return redirect()->to("/dashboard/kelembagaan/" . session('user_id'))
            ->with('success', 'Data kelembagaan berhasil disimpan. Total nilai: ' . $data['total_nilai']);
    }
}
