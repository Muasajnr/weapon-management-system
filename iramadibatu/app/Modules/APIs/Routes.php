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
        });
    });
});