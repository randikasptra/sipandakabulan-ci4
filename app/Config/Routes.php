<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Redirect root ke /login
$routes->get('/', function () {
    if (session()->get('logged_in')) {
        return redirect()->to('/dashboard/' . session()->get('role'));
    } else {
        return redirect()->to('/login');
    }
});

// Form login dan proses login
$routes->get('/login', 'Auth::showLogin'); 
$routes->post('/login', 'Auth::login');    

// Logout
$routes->get('/logout', 'Auth::logout');

// Dashboard role
$routes->get('dashboard', 'Dashboard::admin');
$routes->group('dashboard', function ($routes) {
    $routes->get('admin', 'Dashboard::admin');
    $routes->get('operator', 'Dashboard::operator');
});


