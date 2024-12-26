<?php

namespace config;

use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Config\Services;


/**
 * @var RouteCollection $routes
 */

$routes->get('/', function () {
    return redirect()->to('/dashboard');
});

$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DashboardController::index');
});

$routes->group('katalog', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'KatalogController::index');
    $routes->get('create', 'KatalogController::create');
    $routes->get('edit/(:any)', 'KatalogController::edit/$1');
    $routes->post('store', 'KatalogController::store');
    $routes->post('update/(:any)', 'KatalogController::update/$1');
    $routes->get('delete/(:any)', 'KatalogController::delete/$1');
});

$routes->group('anggota', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AnggotaController::index');
    $routes->get('create', 'AnggotaController::create');
    $routes->get('edit/(:any)', 'AnggotaController::edit/$1');
    $routes->post('store', 'AnggotaController::store');
    $routes->post('update/(:any)', 'AnggotaController::update/$1');
    $routes->get('delete/(:any)', 'AnggotaController::delete/$1');
});

$routes->group('transaksi', ['filter' => 'auth'], function ($routes) {
    // $routes->get('/', 'TransaksiController::index');
    $routes->get('/', function () {
        return redirect()->to('/peminjaman');
    });
    // $routes->get('updatesisahari', 'TransaksiController::updateSisaHari');
    $routes->get('peminjaman', 'TransaksiController::peminjaman');
    $routes->get('entry-peminjaman', 'TransaksiController::entrypeminjaman');
    $routes->get('pengembalian', 'TransaksiController::pengembalian');
    $routes->get('entry-pengembalian', 'TransaksiController::entrypengembalian');
    $routes->post('handlePengembalian', 'TransaksiController::handlePengembalian');
    $routes->get('invoice/(:any)', 'TransaksiController::invoice/$1');
    $routes->post('update/(:any)', 'TransaksiController::update/$1');
    $routes->get('batalkanBuku/(:any)', 'TransaksiController::batalkanBuku/$1');
    $routes->post('store', 'TransaksiController::store');
    $routes->post('finalizePeminjaman/(:any)', 'TransaksiController::finalizePeminjaman/$1');
    $routes->post('batalkanTransaksi/(:num)', 'TransaksiController::batalkanTransaksi/$1');
    $routes->post('checkAnggota', 'TransaksiController::checkAnggota');
    $routes->post('tambahBuku', 'TransaksiController::tambahBuku');
});

$routes->get('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');
$routes->post('login/process', 'AuthController::processLogin');
$routes->post('register/process', 'AuthController::processRegister');
