<?php

$routes->group('api', ['namespace' => '\App\Modules\Api\Controllers\\'], function($routes) {
    $routes->post('login', 'ApiAuthController::handleLogin');
    $routes->post('renew/token', 'ApiAuthController::renewAccessToken');
    $routes->post('logout', 'ApiAuthController::handleLogout');
});