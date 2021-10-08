<?php
$routes->group('api/v1/dashboard/master', ['namespace' => $routeNamespace], function($routes) {
    $routes->group('jenis_inventaris', function($routes) {
        $routes->post('datatables', 'JenisInventarisController::datatables');
    });
    $routes->group('jenis_sarana', function($routes) {
        $routes->post('datatables', 'JenisSaranaController::datatables');
    });
    $routes->group('merk_sarana', function($routes) {
        $routes->post('datatables', 'MerkSsaranaController::datatables');
    });
});