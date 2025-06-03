<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class DownloadController extends BaseController
{
    public function index()
    {
        //
    }

    public function generateExcel()
    {
        $klaster = $this->request->getGet('klaster');
        $poin = $this->request->getGet('poin');

        $cleanKlaster = preg_replace('/[^a-zA-Z0-9_]/', '_', $klaster);
        $cleanPoin = preg_replace('/[^a-zA-Z0-9_]/', '_', $poin);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nilai');

        $sheet->setCellValue('A2', 'Klaster: ' . $klaster);
        $sheet->setCellValue('B2', 'Poin: ' . $poin);

        $filename = "Template_{$cleanKlaster}_{$cleanPoin}.xlsx";
        $filepath = WRITEPATH . 'downloads/' . $filename;

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($filepath);

        return $this->response->download($filepath, null)->setFileName($filename);
    }
}
