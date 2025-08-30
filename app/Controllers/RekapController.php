<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KelembagaanModel;
use App\Models\Klaster1Model;
use App\Models\Klaster2Model;
use App\Models\Klaster3Model;
use App\Models\Klaster4Model;
use App\Models\Klaster5Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $kelembagaanModel = new KelembagaanModel();
        $klasterModels = [
            'Kelembagaan' => $kelembagaanModel,
            'Klaster 1'   => new Klaster1Model(),
            'Klaster 2'   => new Klaster2Model(),
            'Klaster 3'   => new Klaster3Model(),
            'Klaster 4'   => new Klaster4Model(),
            'Klaster 5'   => new Klaster5Model(),
        ];

        // Ambil semua operator
        $users = $userModel->where('role', 'operator')->findAll();
        $rekap = [];

        foreach ($users as $user) {
            foreach ($klasterModels as $namaKlaster => $model) {
                $row = $model->where('user_id', $user['id'])->first();
                $rekap[] = [
                    'desa'      => $user['desa'] ?? '-',
                    'operator'  => $user['username'],
                    'klaster'   => $namaKlaster,
                    'status'    => $row['status'] ?? 'pending',
                    'approved_at' => $row['approved_at'] ?? '-',
                ];
            }
        }

        $data['rekap'] = $rekap;
        return view('pages/admin/rekap_list', $data);
    }

    public function exportExcel()
    {
        $userModel = new UserModel();
        $kelembagaanModel = new KelembagaanModel();
        $klasterModels = [
            'Kelembagaan' => $kelembagaanModel,
            'Klaster 1'   => new Klaster1Model(),
            'Klaster 2'   => new Klaster2Model(),
            'Klaster 3'   => new Klaster3Model(),
            'Klaster 4'   => new Klaster4Model(),
            'Klaster 5'   => new Klaster5Model(),
        ];

        $users = $userModel->where('role', 'operator')->findAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Desa');
        $sheet->setCellValue('B1', 'Operator');
        $sheet->setCellValue('C1', 'Klaster');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Tanggal Approve');

        $rowNum = 2;
        foreach ($users as $user) {
            foreach ($klasterModels as $namaKlaster => $model) {
                $row = $model->where('user_id', $user['id'])->first();
                $sheet->setCellValue("A$rowNum", $user['desa'] ?? '-');
                $sheet->setCellValue("B$rowNum", $user['username']);
                $sheet->setCellValue("C$rowNum", $namaKlaster);
                $sheet->setCellValue("D$rowNum", $row['status'] ?? 'pending');
                $sheet->setCellValue("E$rowNum", $row['approved_at'] ?? '-');
                $rowNum++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Rekap-Approve.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
