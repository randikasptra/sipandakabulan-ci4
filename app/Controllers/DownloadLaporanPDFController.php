<?php

namespace App\Controllers;

use App\Models\KelembagaanModel;
use Dompdf\Dompdf;

class DownloadLaporanPDFController extends BaseController
{
    public function kelembagaan($user_id)
{
    $kelembagaanModel = new \App\Models\KelembagaanModel();
    $db = \Config\Database::connect();

    // ambil data lengkap
    $data = $db->table('kelembagaan')
        ->select('kelembagaan.*, users.desa, berkas_klaster.klaster, berkas_klaster.bulan, berkas_klaster.tahun, berkas_klaster.total_nilai')
        ->join('users', 'users.id = kelembagaan.user_id')
        ->join('berkas_klaster', 'berkas_klaster.user_id = kelembagaan.user_id AND berkas_klaster.tahun = kelembagaan.tahun AND berkas_klaster.bulan = kelembagaan.bulan')
        ->where('kelembagaan.user_id', $user_id)
        ->orderBy('kelembagaan.id', 'DESC')
        ->get()
        ->getRowArray();

    if (!$data) {
        return redirect()->back()->with('error', 'Data kelembagaan tidak ditemukan.');
    }

    // Konversi klaster ID ke nama klaster (jika perlu)
    $data['klaster'] = 'Kelembagaan'; // bisa diganti dinamis jika ada tabel klasters

    // Load DomPDF
    $dompdf = new \Dompdf\Dompdf();
    $html = view('pdf/kelembagaan_pdf', ['data' => $data]);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $dompdf->stream('Laporan_Kelembagaan.pdf', ['Attachment' => false]);
}

}
