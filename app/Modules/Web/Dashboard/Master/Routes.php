<?php

$routes->group('dashboard/master', ['namespace' => $routeNamespace], function($routes) {
    $routes->get('jenis_inventaris', 'DefaultController::jenisInventaris', ['as' => 'jenis_inventaris']);
    $routes->get('jenis_sarana', 'DefaultController::jenisSarana', ['as' => 'jenis_sarana']);
    $routes->get('merk_sarana', 'DefaultController::merkSarana', ['as' => 'merk_sarana']);
});