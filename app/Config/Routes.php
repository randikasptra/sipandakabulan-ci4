<?php

use CodeIgniter\Router\RouteCollection;



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
        $routes->post('users/(:num)/delete', 'AdminDashboard::delete/$1');
        $routes->get('users/(:num)/edit', 'AdminDashboard::editUser/$1');
        $routes->post('users/(:num)/update', 'AdminDashboard::updateUser/$1');
        $routes->get('approve/(:num)', 'AdminDashboard::approve/$1');
        $routes->get('approveAction/(:num)', 'AdminDashboard::approveAction');
        // $routes->get('kelembagaan/(:num)', 'AdminDashboard::reviewKelembagaan/$1');
        $routes->get('review_kelembagaan/(:num)', 'AdminDashboard::reviewKelembagaan/$1');
    });


    $routes->get('pengumuman/delete/(:num)', 'PengumumanController::delete/$1');
    $routes->get('users', 'AdminDashboard::users');       // /dashboard/users
    $routes->get('desa', 'AdminDashboard::desa');         // /dashboard/desa
    $routes->get('klaster', 'AdminDashboard::klaster');   // /dashboard/klaster
    $routes->get('approve_list', 'AdminDashboard::approveList');
    $routes->get('approval', 'ApprovalController::index');
    $routes->post('approval/approve/(:num)', 'ApprovalController::approve/$1');
    $routes->post('approval/reject/(:num)', 'ApprovalController::reject/$1');
    $routes->get('approval/data', 'ApprovalController::getData');
    $routes->get('approval/proses/(:num)', 'ApprovalController::proses/$1');

    $routes->get('laporan', 'AdminDashboard::laporan');   // /dashboard/laporan
    $routes->get('settings', 'AdminDashboard::settings'); // /dashboard/settings

    $routes->get('pengumuman_list', 'PengumumanController::index');
    $routes->get('/pengumuman/create', 'PengumumanController::create');
    $routes->get('/pengumuman/delete/(:num)', 'PengumumanController::delete/$1');
    $routes->post('pengumuman/update', 'PengumumanController::update');
    $routes->get('pengumuman_user', 'Dashboard::pengumuman_user');

    // $routes->post('/pengumuman_list/store', 'PengumumanController::store');

    // OPERATOR ROUTES - tetap di controller Dashboard
    $routes->get('tutorial', 'Dashboard::tutorial');
    $routes->get('operator', 'Dashboard::index/operator');
    $routes->get('kelembagaan/(:num)', 'Dashboard::kelembagaan/$1');
    $routes->get('klaster1/(:num)', 'Dashboard::klaster1/$1');
    $routes->get('klaster2/(:num)', 'Dashboard::klaster2/$1');
    $routes->get('klaster3/(:num)', 'Dashboard::klaster3/$1');
    $routes->get('klaster4/(:num)', 'Dashboard::klaster4/$1');
    $routes->get('klaster5/(:num)', 'Dashboard::klaster5/$1');
});


$routes->get('dashboard/admin/download_file', 'AdminDashboard::downloadFile');

$routes->post('/dashboard/pengumuman_list/store', 'PengumumanController::store');



$routes->get('download/kelembagaan/(:num)', 'DownloadController::kelembagaan/$1');



$routes->get('/kelembagaan/form', 'Kelembagaan::form');
$routes->post('/submit-kelembagaan', 'Kelembagaan::submit');
$routes->get('/klaster1', 'Klaster1Controller::index');
$routes->post('/submit-klaster1', 'Klaster1Controller::submit');
$routes->post('/submit-klaster2', 'Klaster2Controller::submit');
$routes->post('/submit-klaster3', 'Klaster3Controller::submit');
$routes->post('/submit-klaster4', 'Klaster4Controller::submit');
$routes->post('/submit-klaster5', 'Klaster5Controller::submit');


// Download
$routes->get('download', 'DownloadController::generateExcel');
