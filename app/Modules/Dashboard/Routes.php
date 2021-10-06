<?php

$namespace = '\App\Modules\Dashboard\Controllers\\';

$routes->group('dashboard', ['namespace' => $namespace], function($routes) {
    $routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);
    /**users */
    $routes->group('users', function($routes) {
        $routes->get('/', 'UserController::index');
    });
    /**berita acara */
    $routes->group('beritaacara', function($routes) {
        $routes->get('/', 'BeritaAcaraController::index');
        $routes->get('(:segment)/show', 'BeritaAcaraController::show/$1');
    });
});