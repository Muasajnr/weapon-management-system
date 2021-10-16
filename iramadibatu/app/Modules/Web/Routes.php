<?php

$routes->get('login', '\App\Modules\Web\Login\Controllers\DefaultController::login'); // done

$routes->group('dashboard', ['namespace' => '\App\Modules\Web\\'], function($routes) {
    $routes->get('/', 'Dashboard\Home\Controllers\DefaultController::index', ['as' => 'dashboard']);

    $routes->group('master', function($routes) {
        $controllerPath = 'Dashboard\Master\Controllers\\';
        
        $routes->get('jenis_inventaris', $controllerPath.'DefaultController::jenisInventaris', ['as' => 'jenis_inventaris']); // done
        $routes->get('jenis_sarana', $controllerPath.'DefaultController::jenisSarana', ['as' => 'jenis_sarana']); // done
        $routes->get('merk_sarana', $controllerPath.'DefaultController::merkSarana', ['as' => 'merk_sarana']); // done
    });

    $routes->group('sarana_keamanan', function($routes) {
        $controllerPath = 'Dashboard\SaranaKeamanan\Controllers\\';

        $routes->get('senjata_api', $controllerPath.'DefaultController::senjataApi', ['as' => 'senjata_api']); // done
        $routes->get('senjata_api/(:segment)/show', $controllerPath.'DefaultController::senjataApiShow/$1', ['as' => 'senjata_api_show']);
        $routes->get('non_organik', $controllerPath.'DefaultController::nonOrganik', ['as' => 'non_organik']); // done
        $routes->get('lainnya', $controllerPath.'DefaultController::lainnya', ['as' => 'lainnya']); // done
    });

    $routes->group('bon_pinjam_sarana', function($routes) {
        $controllerPath = 'Dashboard\BonPinjamSarana\Controllers\\';

        $routes->get('pinjam', $controllerPath.'DefaultController::pinjam', ['as' => 'pinjam']);
        $routes->get('kembalikan', $controllerPath.'DefaultController::kembalikan', ['as' => 'kembalikan']);
    });

    $routes->get('distribusi', 'Dashboard\DistribusiSarana\Controllers\DefaultController::index', ['as' => 'distribusi']);
    
    $routes->group('berita_acara', function($routes) {
        $routes->get('list', 'Dashboard\BeritaAcara\Controllers\DefaultController::index', ['as' => 'berita_acara']);
        $routes->get('(:segment)/detail', 'Dashboard\BeritaAcara\Controllers\DefaultController::show/$1', ['as' => 'berita_acara_detail']);
        $routes->get('penanggung_jawab', 'Dashboard\BeritaAcara\Controllers\PenanggungJawabController::list', ['as' => 'penanggung_jawab']);
    });

    $routes->group('stok', function($routes) {
        $routes->get('/', 'Dashboard\Stok\Controllers\DefaultController::index', ['as' => 'stok']);
        $routes->get('(:segment)/detail', 'Dashboard\Stok\Controllers\DefaultController::show/$1', ['as' => 'stok_detail']);
    });
    $routes->get('laporan', 'Dashboard\Laporan\Controllers\DefaultController::index', ['as' => 'laporan']);

    $routes->get('users', 'Dashboard\Users\Controllers\DefaultController::index', ['as' => 'users']);
    // $routes->get('test_index2', 'Dashboard\Users\Controllers\DefaultController::index2', ['as' => 'text_index2']);

    $routes->get('qr_scanner','Dashboard\QRScanner\Controllers\DefaultController::index', ['as' => 'qr_scanner']);
});