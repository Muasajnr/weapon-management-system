<?php

$routes->group('api/v1', ['namespace' => $routeNamespace], function($routes) {
    $routes->post('login', 'DefaultController::login');
    $routes->post('token/renew', 'DefaultController::renewToken');
    $routes->post('logout', 'DefaultController::logout');
});