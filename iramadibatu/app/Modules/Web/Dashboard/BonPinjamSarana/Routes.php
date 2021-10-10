<?php

$routes->group('dashboard/bon_pinjam_sarana', ['namespace' => $routeNamespace], function($routes) {
    $routes->get('pinjam', 'DefaultController::pinjam', ['as' => 'pinjam']);
    $routes->get('kembalikan', 'DefaultController::kembalikan', ['as' => 'kembalikan']);
});