<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class LaporanDetailController extends BaseController
{
    public function detail($klaster, $userId)
    {
        helper('model'); // untuk getFileFieldsFromModel()

        $klaster = strtolower($klaster); // contoh: klaster1
        $modelName = "\\App\\Models\\" . ucfirst($klaster) . "Model";

        if (!class_exists($modelName)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Model klaster tidak ditemukan");
        }

        $model = new $modelName();
        $indikatorList = getFileFieldsFromModel($model);

        // $data = $model->where('user_id', $userId)->first();
        $data = $model->where('user_id', $userId)->orderBy('created_at', 'desc')->first();


        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan");
        }

        return view('pages/admin/detail_laporan', [
            'title' => 'Detail Laporan',
            'data' => $data,
            'indikatorList' => $indikatorList,
            'folder' => $klaster
        ]);
    }
}
