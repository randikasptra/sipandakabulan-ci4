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
        $routes->get('/', 'AdminDashboard::index');
        $routes->post('users/create', 'AdminDashboard::storeUser');
        $routes->post('users/(:num)/delete', 'AdminDashboard::delete/$1');
        $routes->get('users/(:num)/edit', 'AdminDashboard::editUser/$1');
        $routes->post('users/(:num)/update', 'AdminDashboard::updateUser/$1');
        $routes->get('approve/(:num)', 'AdminDashboard::approve/$1');
        $routes->get('approveAction/(:num)', 'AdminDashboard::approveAction');
        $routes->get('approve/confirm(:num)', 'AdminDashboard::setuju/$1');
        $routes->get('review_kelembagaan/(:num)', 'AdminDashboard::reviewKelembagaan/$1');

        // Review Klaster 1 - 5
        $routes->get('review_klaster_1/(:num)', 'AdminDashboard::reviewKlaster1/$1');
        $routes->get('review_klaster_2/(:num)', 'AdminDashboard::reviewKlaster2/$1');
        $routes->get('review_klaster_3/(:num)', 'AdminDashboard::reviewKlaster3/$1');
        $routes->get('review_klaster_4/(:num)', 'AdminDashboard::reviewKlaster4/$1');
        $routes->get('review_klaster_5/(:num)', 'AdminDashboard::reviewKlaster5/$1');

        $routes->get('review/(:num)', 'AdminBerkasController::review/$1');
        $routes->post('update_status', 'AdminBerkasController::updateStatus');
        $routes->post('admin-berkas/store', 'AdminBerkasController::store');

        // Approve klaster 1 dan 2 (kalau klaster lain menyusul)
        $routes->post('klaster1/approve', 'Klaster1Controller::approve');
        $routes->post('klaster2/approve', 'Klaster2Controller::approve');
        $routes->post('klaster3/approve', 'Klaster3Controller::approve');
        $routes->post('klaster4/approve', 'Klaster4Controller::approve');
        $routes->post('klaster5/approve', 'Klaster5Controller::approve');
        
    });

    $routes->get('berkas', 'AdminBerkasController::index');
    $routes->post('berkas/update-status', 'AdminBerkasController::updateStatus');
    $routes->get('pengumuman/delete/(:num)', 'PengumumanController::delete/$1');
    $routes->get('users', 'AdminDashboard::users');
    $routes->get('desa', 'AdminDashboard::desa');
    $routes->get('klaster', 'AdminDashboard::klaster');
    $routes->get('approve_list', 'AdminDashboard::approveList');
    $routes->get('approval', 'ApprovalController::index');
    $routes->post('approval/approve/(:num)', 'ApprovalController::approve/$1');
    $routes->post('approval/reject/(:num)', 'ApprovalController::reject/$1');
    $routes->get('approval/data', 'ApprovalController::getData');
    $routes->get('approval/proses/(:num)', 'ApprovalController::proses/$1');
    $routes->get('settings', 'AdminDashboard::settings');

    $routes->get('pengumuman_list', 'PengumumanController::index');
    $routes->get('/pengumuman/create', 'PengumumanController::create');
    $routes->get('/pengumuman/delete/(:num)', 'PengumumanController::delete/$1');
    $routes->post('pengumuman/update', 'PengumumanController::update');
    $routes->get('pengumuman_user', 'Dashboard::pengumuman_user');

    // OPERATOR ROUTES
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

// Form untuk operator (submit & form view)
$routes->get('/kelembagaan/form', 'Kelembagaan::form');
$routes->post('/submit-kelembagaan', 'Kelembagaan::submit');

$routes->get('/klaster1', 'Klaster1Controller::index');
$routes->get('/klaster1/form', 'Klaster1Controller::form'); 
$routes->get('/klaster2/form', 'Klaster2Controller::form'); 
$routes->get('/klaster3/form', 'Klaster3Controller::form'); 
$routes->get('/klaster4/form', 'Klaster4Controller::form'); 
$routes->get('/klaster5/form', 'Klaster5Controller::form'); 
$routes->post('/submit-klaster1', 'Klaster1Controller::submit');
$routes->post('/submit-klaster2', 'Klaster2Controller::submit');
$routes->post('/submit-klaster3', 'Klaster3Controller::submit');
$routes->post('/submit-klaster4', 'Klaster4Controller::submit');
$routes->post('/submit-klaster5', 'Klaster5Controller::submit');

// Download general
$routes->get('download', 'DownloadController::generateExcel');
