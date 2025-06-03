<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DownloadController extends Controller
{
    public function generateExcel()
    {
        $file = $this->request->getGet('file');

        // Validasi nama file
        if (!preg_match('/^[\w,\s-]+\.(xlsx|xls)$/', $file)) {
            return $this->response->setStatusCode(400)->setBody("Invalid file name.");
        }

        $filePath = FCPATH . 'template_excel/' . $file;

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody("File not found: $file");
        }

        return $this->response->download($filePath, null)->setFileName($file);
    }
}
