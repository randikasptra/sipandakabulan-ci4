<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

class DownloadLaporanPDFController extends BaseController
{
    public function download($jenis_klaster, $id)
    {
        $db = \Config\Database::connect();

        // Mapping nama view dan nama tabel
        $viewMap = [
            'kelembagaan' => 'pdf/kelembagaan_pdf',
            'klaster1'     => 'pdf/klaster1_pdf',
            'klaster2'     => 'pdf/klaster2_pdf',
            'klaster3'     => 'pdf/klaster3_pdf',
            'klaster4'     => 'pdf/klaster4_pdf',
            'klaster5'     => 'pdf/klaster5_pdf',
        ];

        $tableMap = [
            'kelembagaan' => 'kelembagaan',
            'klaster1'     => 'klaster1',
            'klaster2'     => 'klaster2',
            'klaster3'     => 'klaster3',
            'klaster4'     => 'klaster4',
            'klaster5'     => 'klaster5',
        ];

        // Cek jika jenis klaster valid
        if (!isset($viewMap[$jenis_klaster]) || !isset($tableMap[$jenis_klaster])) {
            return redirect()->back()->with('error', 'Jenis klaster tidak valid.');
        }

        $table = $tableMap[$jenis_klaster];
        $view  = $viewMap[$jenis_klaster];

        // Ambil data umum
        $data = $db->table($table)
            ->select("{$table}.*, users.desa, berkas_klaster.klaster, berkas_klaster.bulan, berkas_klaster.tahun, berkas_klaster.total_nilai")
            ->join('users', "users.id = {$table}.user_id")
            ->join('berkas_klaster', "berkas_klaster.user_id = {$table}.user_id AND berkas_klaster.tahun = {$table}.tahun AND berkas_klaster.bulan = {$table}.bulan")
            ->where("{$table}.user_id", $id)
            ->orderBy("{$table}.id", 'DESC')
            ->get()
            ->getRowArray();

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $data['klaster'] = ucfirst($jenis_klaster);

        // Buat PDF
        $dompdf = new Dompdf();
        $html = view($view, ['data' => $data]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("Laporan_" . ucfirst($jenis_klaster) . ".pdf", ['Attachment' => false]);
    }
}
