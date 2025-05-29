<?php

namespace App\Controllers;

use App\Models\KlasterFormModel;

class Dashboard extends BaseController
{
    public function admin()
    {
        return view('pages/admin/dashboard', ['title' => 'Dashboard Admin']);
    }

    public function operator()
    {
        $klasterModel = new KlasterFormModel();
        $klasters = $klasterModel->findAll();

        return view('pages/operator/dashboard', [
            'title' => 'Dashboard Operator',
            'klasters' => $klasters
        ]);
    }
}
