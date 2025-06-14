<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\KelembagaanController;



/**
 * @var RouteCollection $routes
 */

// Redirect root ke /login atau /dashboard/role
$routes->get('/', function () {
    if (session()->get('logged_in')) {
        return redirect()->to('/dashboard/' . session()->get('role'));
    } else {
        return redirect()->to('/login');
    }
});

// Login & Logout
$routes->get('/login', 'Auth::showLogin');
$routes->post('/login', 'Auth::login');
$routes->post('/logout', 'Auth::logout');

// DASHBOARD GROUP
$routes->group('dashboard', function ($routes) {
    // ADMIN ROUTES - menggunakan controller AdminDashboard
    $routes->group('admin', function ($routes) {
        $routes->get('/', 'AdminDashboard::index'); // /dashboard/admin
        $routes->post('users/create', 'AdminDashboard::storeUser');
    });

    $routes->get('users', 'AdminDashboard::users');       // /dashboard/users
    $routes->get('desa', 'AdminDashboard::desa');         // /dashboard/desa
    $routes->get('klaster', 'AdminDashboard::klaster');   // /dashboard/klaster
    $routes->get('approval', 'ApprovalController::index');
    $routes->post('approval/approve/(:num)', 'ApprovalController::approve/$1');
    $routes->post('approval/reject/(:num)', 'ApprovalController::reject/$1');
    $routes->get('approval/data', 'ApprovalController::getData');
    $routes->get('approval/proses/(:num)', 'ApprovalController::proses/$1');

    $routes->get('laporan', 'AdminDashboard::laporan');   // /dashboard/laporan
    $routes->get('settings', 'AdminDashboard::settings'); // /dashboard/settings

    // OPERATOR ROUTES - tetap di controller Dashboard
    $routes->get('operator', 'Dashboard::index/operator');
    $routes->get('kelembagaan/(:num)', 'Dashboard::kelembagaan/$1');
    $routes->get('klaster1/(:num)', 'Dashboard::klaster1/$1');
});




$routes->get('/kelembagaan/form', 'KelembagaanController::formKelembagaan');
$routes->post('/submit-kelembagaan', 'KelembagaanController::submitKelembagaan');


// Download
$routes->get('download', 'DownloadController::generateExcel');
