<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use App\Models\KelembagaanModel;
use App\Models\UserModel;

class LaporanController extends BaseController
{
    public function kelembagaanPDF($id)
    {
        $kelembagaanModel = new KelembagaanModel();
        $userModel = new UserModel();

        $data = $kelembagaanModel->find($id);
        if (!$data || $data['status'] !== 'approved') {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau belum disetujui.');
        }

        $user = $userModel->find($data['user_id']);

        // Soal + indikator
        $indikator = [
            [
                'judul' => '1. Adanya Peraturan yang mencakup lima klaster',
                'nama' => 'peraturan',
                'nilai' => $data['peraturan_value'],
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => 'Ada 1 SK',
                    30 => 'Ada 2–3 SK',
                    45 => 'Ada 4 SK',
                    60 => 'Ada ≥5 SK'
                ],
                'file' => $data['peraturan_file']
            ],
            [
                'judul' => '2. Adanya Anggaran Responsif Anak',
                'nama' => 'anggaran',
                'nilai' => $data['anggaran_value'],
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => '≤5%',
                    20 => '6–10%',
                    35 => '11–20%',
                    50 => '≥30%'
                ],
                'file' => $data['anggaran_file']
            ],
            [
                'judul' => '3. Ada Forum Anak Desa',
                'nama' => 'forum_anak',
                'nilai' => $data['forum_anak_value'],
                'opsi' => [
                    0 => 'Tidak ada',
                    13 => 'Ada tapi tidak aktif',
                    26 => 'Ada, aktif sesekali',
                    40 => 'Ada dan aktif rutin'
                ],
                'file' => $data['forum_anak_file']
            ],
            [
                'judul' => '4. Ada Data Terpilah mencakup 5 klaster',
                'nama' => 'data_terpilah',
                'nilai' => $data['data_terpilah_value'],
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => '1 Klaster',
                    30 => '2–3 Klaster',
                    40 => '4 Klaster',
                    50 => '5 Klaster'
                ],
                'file' => $data['data_terpilah_file']
            ],
            [
                'judul' => '5. Dunia Usaha yang Terlibat',
                'nama' => 'dunia_usaha',
                'nilai' => $data['dunia_usaha_value'],
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => '1–2 usaha',
                    15 => '3 usaha',
                    20 => '≥4 usaha'
                ],
                'file' => $data['dunia_usaha_file']
            ]
        ];

        $html = view('pdf/laporan_kelembagaan', [
            'user' => $user,
            'data' => $data,
            'indikator' => $indikator
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Laporan_Kelembagaan_{$user['desa']}.pdf", ["Attachment" => true]);
    }
}
