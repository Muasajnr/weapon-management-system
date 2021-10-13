<?php

$routes->get('login', '\App\Modules\Web\Login\Controllers\DefaultController::login');
$routes->get('login2', '\App\Modules\Web\Login\Controllers\DefaultController::login2');
$routes->get('test_index2', '\App\Modules\Web\Dashboard\Users\Controllers\DefaultController::index2');

$routes->group('dashboard', ['namespace' => '\App\Modules\Web\\'], function($routes) {
    $routes->get('/', 'Dashboard\Home\Controllers\DefaultController::index', ['as' => 'dashboard']);

    $routes->group('master', function($routes) {
        $controllerPath = 'Dashboard\Master\Controllers\\';
        
        $routes->get('jenis_inventaris', $controllerPath.'DefaultController::jenisInventaris', ['as' => 'jenis_inventaris']);
        $routes->get('jenis_sarana', $controllerPath.'DefaultController::jenisSarana', ['as' => 'jenis_sarana']);
        $routes->get('merk_sarana', $controllerPath.'DefaultController::merkSarana', ['as' => 'merk_sarana']);
    });

    $routes->group('sarana_keamanan', function($routes) {
        $controllerPath = 'Dashboard\SaranaKeamanan\Controllers\\';

        $routes->get('senjata_api', $controllerPath.'DefaultController::senjataApi', ['as' => 'senjata_api']);
        $routes->get('non_organik', $controllerPath.'DefaultController::nonOrganik', ['as' => 'non_organik']);
        $routes->get('lainnya', $controllerPath.'DefaultController::lainnya', ['as' => 'lainnya']);
    });

    $routes->group('bon_pinjam_sarana', function($routes) {
        $controllerPath = 'Dashboard\BonPinjamSarana\Controllers\\';

        $routes->get('pinjam', $controllerPath.'DefaultController::pinjam', ['as' => 'pinjam']);
        $routes->get('kembalikan', $controllerPath.'DefaultController::kembalikan', ['as' => 'kembalikan']);
    });

    $routes->get('distribusi', 'Dashboard\DistribusiSarana\Controllers\DefaultController::index', ['as' => 'distribusi']);
    $routes->get('berita_acara', 'Dashboard\BeritaAcara\Controllers\DefaultController::index', ['as' => 'berita_acara']);
    $routes->group('stok', function($routes) {
        $routes->get('/', 'Dashboard\Stok\Controllers\DefaultController::index', ['as' => 'stok']);
        $routes->get('(:segment)/detail', 'Dashboard\Stok\Controllers\DefaultController::show/$1', ['as' => 'stok_detail']);
    });
    $routes->get('laporan', 'Dashboard\Laporan\Controllers\DefaultController::index', ['as' => 'laporan']);

    $routes->get('users', 'Dashboard\Users\Controllers\DefaultController::index', ['as' => 'users']);
    // $routes->get('test_index2', 'Dashboard\Users\Controllers\DefaultController::index2', ['as' => 'text_index2']);

    $routes->get('qr_scanner','Dashboard\QRScanner\Controllers\DefaultController::index', ['as' => 'qr_scanner']);
});