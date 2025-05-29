<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Redirect root ke /login
// Redirect root ke /login
$routes->get('/', function () {
    if (session()->get('logged_in')) {
        return redirect()->to('/dashboard/' . session()->get('role'));
    } else {
        return redirect()->to('/login');
    }
});

// Login routes
$routes->get('/login', 'Auth::showLogin'); 
$routes->post('/login', 'Auth::login');    

// Logout
$routes->get('/logout', 'Auth::logout');

// Dashboard routes
$routes->group('dashboard', function ($routes) {
    $routes->get('/', 'Dashboard::index');               // /dashboard
    $routes->get('admin', 'Dashboard::index/admin');     // /dashboard/admin
    $routes->get('operator', 'Dashboard::index/operator'); // /dashboard/operator
});
