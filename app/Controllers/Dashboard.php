<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        return view('pages/admin/dashboard', ['title' => 'Dashboard Admin']);
    }

    public function operator()
    {
        return view('pages/operator/dashboard', ['title' => 'Dashboard Operator']);
    }
}
 