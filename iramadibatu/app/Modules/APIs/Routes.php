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
                $routes->get('(:segment)', 'Master\Controllers\JenisInventarisController::get/$1'); // works

                $routes->post('datatables', 'Master\Controllers\JenisInventarisController::datatables'); // works
                $routes->post('/', 'Master\Controllers\JenisInventarisController::create'); // works

                $routes->put('(:segment)/update', 'Master\Controllers\JenisInventarisController::update/$1'); // works
                $routes->put('(:segment)/set_status', 'Master\Controllers\JenisInventarisController::setStatus/$1'); // works

                $routes->delete('(:segment)/delete', 'Master\Controllers\JenisInventarisController::delete/$1'); // works
                $routes->delete('delete/multiple', 'Master\Controllers\JenisInventarisController::deleteMultiple'); // works
            });
            
            $routes->group('jenis_sarana', function($routes) {
                $routes->get('/', 'Master\Controllers\JenisSaranaController::index');
                $routes->get('(:segment)', 'Master\Controllers\JenisSaranaController::get/$1'); // works

                $routes->post('datatables', 'Master\Controllers\JenisSaranaController::datatables'); // works
                $routes->post('/', 'Master\Controllers\JenisSaranaController::create'); // works

                $routes->put('(:segment)/update', 'Master\Controllers\JenisSaranaController::update/$1'); // works
                $routes->put('(:segment)/set_status', 'Master\Controllers\JenisSaranaController::setStatus/$1'); // works

                $routes->delete('(:segment)/delete', 'Master\Controllers\JenisSaranaController::delete/$1'); // works
                $routes->delete('delete/multiple', 'Master\Controllers\JenisSaranaController::deleteMultiple'); // works
            });

            $routes->group('merk_sarana', function($routes) {
                $routes->get('/', 'Master\Controllers\MerkSaranaController::index');
                $routes->get('(:segment)', 'Master\Controllers\MerkSaranaController::get/$1'); // works

                $routes->post('datatables', 'Master\Controllers\MerkSaranaController::datatables'); // works
                $routes->post('/', 'Master\Controllers\MerkSaranaController::create'); // works

                $routes->put('(:segment)/update', 'Master\Controllers\MerkSaranaController::update/$1'); // works
                $routes->put('(:segment)/set_status', 'Master\Controllers\MerkSaranaController::setStatus/$1'); // works

                $routes->delete('(:segment)/delete', 'Master\Controllers\MerkSaranaController::delete/$1'); // works
                $routes->delete('delete/multiple', 'Master\Controllers\MerkSaranaController::deleteMultiple'); // works
            });
        });

        $routes->group('sarana_keamanan', function($routes) {
            $routes->get('/', 'SaranaKeamanan\Controllers\DefaultController::index');
            $routes->get('(:segment)', 'SaranaKeamanan\Controllers\DefaultController::get/$1'); // works

            $routes->post('datatable', 'SaranaKeamanan\Controllers\DefaultController::datatable'); // works
            $routes->post('/', 'SaranaKeamanan\Controllers\DefaultController::create'); // works
            $routes->post('(:segment)/update', 'SaranaKeamanan\Controllers\DefaultController::update/$1'); // works

            $routes->delete('(:segment)/delete', 'SaranaKeamanan\Controllers\DefaultController::delete/$1'); // works
            $routes->delete('delete/multiple', 'SaranaKeamanan\Controllers\DefaultController::deleteMultiple'); // works
        });

        $routes->group('berita_acara', function($routes) {
            $routes->get('/', 'BeritaAcara\Controllers\DefaultController::index'); // works

            $routes->post('datatables', 'BeritaAcara\Controllers\DefaultController::datatables'); // works
            $routes->post('/', 'BeritaAcara\Controllers\DefaultController::create'); // works
            $routes->post('(:segment)/update', 'BeritaAcara\Controllers\DefaultController::update/$1'); // works

            $routes->delete('(:segment)/delete', 'BeritaAcara\Controllers\DefaultController::delete/$1'); // works
            $routes->delete('delete/multiple', 'BeritaAcara\Controllers\DefaultController::deleteMultiple'); // works

            $routes->group('penanggung_jawab', function($routes) {
                $routes->get('/', 'BeritaAcara\Controllers\PenanggungJawabController::index'); // works

                $routes->post('datatable', 'BeritaAcara\Controllers\PenanggungJawabController::datatable'); // works
                $routes->post('/', 'BeritaAcara\Controllers\PenanggungJawabController::create'); // works

                $routes->put('(:segment)/update', 'BeritaAcara\Controllers\PenanggungJawabController::update/$1'); // works

                $routes->delete('(:segment)/delete', 'BeritaAcara\Controllers\PenanggungJawabController::delete/$1'); // works
                $routes->delete('delete/multiple', 'BeritaAcara\Controllers\PenanggungJawabController::deleteMultiple'); // works
            });
        });

        $routes->group('bon_simpan_pinjam', function($routes) {
            $routes->group('pinjam', function($routes) {
                $routes->post('datatables', 'BonSimpanPinjam\Controllers\PinjamController::datatables'); // works
                $routes->post('/', 'BonSimpanPinjam\Controllers\PinjamController::create');

                $routes->put('(:segment)/update', 'BeritaAcara\Controllers\DefaultController::update/$1');

                $routes->delete('(:segment)/delete', 'BeritaAcara\Controllers\DefaultController::delete/$1');
                $routes->delete('delete/multiple', 'BeritaAcara\Controllers\DefaultController::deleteMultiple');
            });

            $routes->group('kembalikan', function($routes) {
                $routes->post('datatables', 'BonSimpanPinjam\Controllers\KembalikanController::datatables'); // works
                $routes->post('/', 'BonSimpanPinjam\Controllers\KembalikanController::create');
                
                $routes->put('(:segment)/update', 'BonSimpanPinjam\Controllers\KembalikanController::update/$1');

                $routes->delete('(:segment)/delete', 'BonSimpanPinjam\Controllers\KembalikanController::delete/$1');
                $routes->delete('delete/multiple', 'BonSimpanPinjam\Controllers\KembalikanController::deleteMultiple');
            });
        });

        $routes->group('distribusi', function($routes) {
            $routes->post('datatables', 'DistribusiSarana\Controllers\DefaultController::datatables'); // works
            $routes->post('/', 'DistribusiSarana\Controllers\DefaultController::create');

            $routes->put('(:segment)/update', 'DistribusiSarana\Controllers\DefaultController::update/$1');

            $routes->delete('(:segment)/delete', 'DistribusiSarana\Controllers\DefaultController::delete/$1');
            $routes->delete('delete/multiple', 'DistribusiSarana\Controllers\DefaultController::deleteMultiple');
        });

        $routes->group('users', function($routes) {
            $routes->get('/', 'Users\Controllers\UserController::index');
            $routes->get('(:segment)', 'Users\Controllers\UserController::get/$1'); // works

            $routes->post('datatables', 'Users\Controllers\UserController::datatables'); // works
            $routes->post('/', 'Users\Controllers\UserController::create'); // works

            $routes->put('(:segment)/update', 'Users\Controllers\UserController::update/$1'); // works
            $routes->put('(:segment)/update_password', 'Users\Controllers\UserController::updatePassword/$1'); // works

            $routes->delete('(:segment)/delete', 'Users\Controllers\UserController::delete/$1'); // works
            $routes->delete('delete/multiple', 'Users\Controllers\UserController::deleteMultiple'); // works
        });

        $routes->group('stok', function($routes) {
            $routes->post('datatables', 'Stok\Controllers\DefaultController::datatables'); // works
            $routes->get('sarana_keamanan', 'Stok\Controllers\DefaultController::getByJenisSarana');
        });
    });
});