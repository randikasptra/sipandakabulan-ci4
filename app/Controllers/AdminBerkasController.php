<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BerkasKlasterModel;
use App\Models\KlasterFormModel;
use CodeIgniter\Database\BaseBuilder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminBerkasController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil input filter dari query string
        $desaFilter = $this->request->getGet('desa');
        $klasterFilter = $this->request->getGet('klaster');
        $searchDesa = $this->request->getGet('search_desa');

        // Query awal untuk ambil berkas yang disetujui
        $builder = $db->table('berkas_klaster')
            ->select('berkas_klaster.*, users.desa, klasters.title as nama_klaster')
            ->join('users', 'users.id = berkas_klaster.user_id')
            ->join('klasters', 'klasters.id = berkas_klaster.klaster')
            ->where('berkas_klaster.status', 'approved');

        // Tambahkan filter jika ada
        if (!empty($desaFilter)) {
            $builder->where('users.desa', $desaFilter);
        }

        if (!empty($klasterFilter)) {
            $builder->where('klasters.title', $klasterFilter);
        }

        if (!empty($searchDesa)) {
            $builder->like('users.desa', $searchDesa);
        }

        $berkas = $builder->orderBy('berkas_klaster.created_at', 'DESC')->get()->getResultArray();

        // Buat chart_data: jumlah laporan dan total_nilai per klaster
        $statistik = [];

        foreach ($berkas as $item) {
            $klaster = $item['nama_klaster'];

            if (!isset($statistik[$klaster])) {
                $statistik[$klaster] = [
                    'jumlah_laporan' => 0,
                    'total_nilai' => 0,
                    'jumlah_desa' => 0
                ];
            }

            $statistik[$klaster]['jumlah_laporan']++;
            $statistik[$klaster]['total_nilai'] += (float) $item['total_nilai'];
            $statistik[$klaster]['jumlah_desa'] = count(array_unique(array_column($berkas, 'desa')));
        }

        // Ambil semua desa unik
        $list_desa = $db->table('users')
            ->select('desa')
            ->distinct()
            ->where('desa IS NOT NULL')
            ->orderBy('desa')
            ->get()
            ->getResultArray();

        // Ambil semua klaster unik
        $list_klaster = $db->table('klasters')
            ->select('title')
            ->distinct()
            ->orderBy('title')
            ->get()
            ->getResultArray();

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Laporan Berkas Disetujui',
            'berkas' => $berkas,
            'chart_data' => json_encode($statistik),
            'list_desa' => array_column($list_desa, 'desa'),
            'list_klaster' => array_column($list_klaster, 'title'),
            'desa_filter' => $desaFilter,
            'klaster_filter' => $klasterFilter,
            'search_desa' => $searchDesa
        ];

        return view('pages/admin/berkas', $data);
    }

public function export()
{
    $db = \Config\Database::connect();

    // Ambil input filter
    $desaFilter = $this->request->getGet('desa');
    $klasterFilter = $this->request->getGet('klaster');
    $searchDesa = $this->request->getGet('search_desa');

    // Query awal untuk ambil berkas yang disetujui
    $builder = $db->table('berkas_klaster')
        ->select('berkas_klaster.*, users.name as nama_user, users.desa, klasters.title as nama_klaster')
        ->join('users', 'users.id = berkas_klaster.user_id')
        ->join('klasters', 'klasters.id = berkas_klaster.klaster')
        ->where('berkas_klaster.status', 'approved');

    // Tambahkan filter
    if (!empty($desaFilter)) {
        $builder->where('users.desa', $desaFilter);
    }
    if (!empty($klasterFilter)) {
        $builder->where('klasters.title', $klasterFilter);
    }
    if (!empty($searchDesa)) {
        $builder->like('users.desa', $searchDesa);
    }

    $berkas = $builder->orderBy('berkas_klaster.created_at', 'DESC')->get()->getResultArray();

    // Buat file Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $sheet->setCellValue('A1', 'Nama User');
    $sheet->setCellValue('B1', 'Desa');
    $sheet->setCellValue('C1', 'Klaster');
    $sheet->setCellValue('D1', 'Total Nilai');
    $sheet->setCellValue('E1', 'Tahun');
    $sheet->setCellValue('F1', 'Bulan');
    $sheet->setCellValue('G1', 'Tanggal Disetujui');

    // Isi data
    $row = 2;
    foreach ($berkas as $item) {
        $sheet->setCellValue('A' . $row, $item['nama_user']);
        $sheet->setCellValue('B' . $row, $item['desa']);
        $sheet->setCellValue('C' . $row, $item['nama_klaster']);
        $sheet->setCellValue('D' . $row, $item['total_nilai']);
        $sheet->setCellValue('E' . $row, $item['tahun']);
        $sheet->setCellValue('F' . $row, $item['bulan']);
        $sheet->setCellValue('G' . $row, $item['updated_at'] ?? $item['created_at']);
        $row++;
    }

    // Styling sederhana (auto width)
    foreach (range('A', 'G') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Download Excel
    $filename = "rekap_berkas_" . date('Ymd_His') . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
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

 public function delete()
{
    $id = $this->request->getPost('id');

    if (!$id) {
        return redirect()->back()->with('error', 'ID tidak ditemukan.');
    }

    $berkasModel = new \App\Models\BerkasKlasterModel();
    $berkas = $berkasModel->find($id);

    if (!$berkas) {
        return redirect()->back()->with('error', 'Data berkas tidak ditemukan.');
    }

    $userId = $berkas['user_id'];
    $bulan = $berkas['bulan'];
    $tahun = $berkas['tahun'];
    $klaster = $berkas['klaster'];

    // Inisialisasi semua model klaster
    $kelembagaanModel = new \App\Models\KelembagaanModel();
    $klaster1Model = new \App\Models\Klaster1Model();
    $klaster2Model = new \App\Models\Klaster2Model();
    $klaster3Model = new \App\Models\Klaster3Model();
    $klaster4Model = new \App\Models\Klaster4Model();
    $klaster5Model = new \App\Models\Klaster5Model();

    // Hapus data berdasarkan klaster
    switch ($klaster) {
        case 1:
            $kelembagaanModel
                ->where('user_id', $userId)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->delete();
            break;
        case 2:
            $klaster1Model
                ->where('user_id', $userId)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->delete();
            break;
        case 3:
            $klaster2Model
                ->where('user_id', $userId)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->delete();
            break;
        case 4:
            $klaster3Model
                ->where('user_id', $userId)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->delete();
            break;
        case 5:
            $klaster4Model
                ->where('user_id', $userId)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->delete();
            break;
        case 6:
            $klaster5Model
                ->where('user_id', $userId)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->delete();
            break;
    }

    // Terakhir: hapus berkas utamanya
    if ($berkasModel->delete($id)) {
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    } else {
        return redirect()->back()->with('error', 'Gagal menghapus data.');
    }
}






    public function store()
    {
        $berkasModel = new BerkasKlasterModel();
        $kelembagaanModel = new \App\Models\KelembagaanModel();
        $klasterSlug = $this->request->getPost('klaster');


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


        if ($data['klaster'] == 1) {
            $kelembagaan = $kelembagaanModel
                ->where('user_id', $data['user_id'])
                ->where('tahun', $data['tahun'])
                ->where('bulan', $data['bulan']) 
                ->first();

            if ($kelembagaan) {
                $kelembagaanModel->update($kelembagaan['id'], [
                    'status' => $data['status']
                ]);
            }
        }


        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');

        if ($status === 'rejected') {
            return redirect()->to('dashboard/admin/approve/' . $userId)->with('success', 'Status berhasil di Tolak.');
        }
        return redirect()->to('dashboard/berkas')->with('success', 'Berkas di Setujui.');


    }

}