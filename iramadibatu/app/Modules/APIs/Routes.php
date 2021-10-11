<?php

$routes->group('api/v1', ['namespace' => '\App\Modules\APIs'], function($routes) {
    $routes->post('login', 'Auth\Controllers\DefaultController::login');
    $routes->post('renew_token', 'Auth\Controllers\DefaultController::renewToken');
    $routes->post('logout', 'Auth\Controllers\DefaultController::logout');

    $routes->group('dashboard', function($routes) {
        $routes->get('/', 'Dashboard\Controllers\DefaultController::index');

        $routes->group('master', function($routes) {
            $routes->group('jenis_inventaris', function($routes) {
                $routes->get('/', 'Master\Controllers\JenisInventarisController::index');
                
                $routes->post('datatables', 'Master\Controllers\JenisInventarisController::datatables');
            });
            
            $routes->group('jenis_sarana', function($routes) {
                $routes->get('/', 'Master\Controllers\JenisSaranaController::index');

                $routes->post('datatables', 'Master\Controllers\JenisSaranaController::datatables');
            });

            $routes->group('merk_sarana', function($routes) {
                $routes->get('/', 'Master\Controllers\MerkSaranaController::index');

                $routes->post('datatables', 'Master\Controllers\MerkSaranaController::datatables');
            });
        });

        $routes->group('sarana_keamanan', function($routes) {
            $routes->get('/', 'SaranaKeamanan\Controllers\DefaultController::index');

            $routes->post('datatables/(:segment)', 'SaranaKeamanan\Controllers\DefaultController::datatables/$1');
            $routes->post('create/(:segment)', 'SaranaKeamanan\Controllers\DefaultController::create/$1');

            // $routes->put('(:id)/update/(:id_jenis_inventaris)', 'SaranaKeamanan\Controllers\DefaultController::update/$1/$2');
        });

        $routes->group('berita_acara', function($routes) {
            $routes->get('/', 'BeritaAcara\Controllers\DefaultController::index');
            $routes->post('datatables', 'BeritaAcara\Controllers\DefaultController::datatables');
        });

        $routes->group('bon_simpan_pinjam', function($routes) {
            $routes->group('pinjam', function($routes) {
                $routes->post('datatables', 'BonSimpanPinjam\Controllers\PinjamController::datatables');
            });
            $routes->group('kembalikan', function($routes) {
                $routes->post('datatables', 'BonSimpanPinjam\Controllers\KembalikanController::datatables');
            });
        });

        $routes->group('distribusi', function($routes) {
            $routes->post('datatables', 'DistribusiSarana\Controllers\DefaultController::datatables');
        });
    });
});