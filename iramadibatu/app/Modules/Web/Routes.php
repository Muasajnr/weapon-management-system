<?php

$routes->get('login', '\App\Modules\Web\Login\Controllers\DefaultController::login');

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

    $routes->group('dashboard/bon_pinjam_sarana', function($routes) {
        $controllerPath = 'Dashboard\BonPinjamSarana\Controllers\\';

        $routes->get('pinjam', $controllerPath.'DefaultController::pinjam', ['as' => 'pinjam']);
        $routes->get('kembalikan', $controllerPath.'DefaultController::kembalikan', ['as' => 'kembalikan']);
    });
});