<?php

$namespace = '\App\Modules\Dashboard\Controllers\\';

$routes->group('dashboard', ['namespace' => $namespace], function($routes) {
    $routes->get('/', 'DashboardController::index', ['as' => 'dashboard']);
    /**users */
    $routes->group('users', function($routes) {
        $routes->get('/', 'UserController::index');
    });
});