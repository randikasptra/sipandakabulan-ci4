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
    });

    $routes->get('users', 'AdminDashboard::users');       // /dashboard/users
    $routes->get('desa', 'AdminDashboard::desa');         // /dashboard/desa
    $routes->get('klaster', 'AdminDashboard::klaster');   // /dashboard/klaster
    $routes->get('approval', 'AdminDashboard::approval');
$routes->post('approval/approve/(:num)', 'AdminDashboard::approveDesa/$1');
$routes->post('approval/reject/(:num)', 'AdminDashboard::rejectDesa/$1');

    $routes->get('laporan', 'AdminDashboard::laporan');   // /dashboard/laporan
    $routes->get('settings', 'AdminDashboard::settings'); // /dashboard/settings

    // OPERATOR ROUTES - tetap di controller Dashboard
    $routes->get('operator', 'Dashboard::index/operator'); 
    $routes->get('kelembagaan/(:num)', 'Dashboard::kelembagaan/$1');
    $routes->get('klaster1/(:num)', 'Dashboard::klaster1/$1');
});



// Download
$routes->get('download', 'DownloadController::generateExcel');
