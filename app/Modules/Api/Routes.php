<?php

$routes->group('api', ['namespace' => '\App\Modules\Api\Controllers\\'], function($routes) {
    $routes->post('login', 'ApiAuthController::handleLogin');
    $routes->post('renew/token', 'ApiAuthController::renewAccessToken');
    $routes->post('logout', 'ApiAuthController::handleLogout');

    /** dashboard */
    $routes->group('dashboard', function($routes) {
        /** users */
        $routes->group('users', function($routes) {
            /** get operation */
            $routes->get('/', 'ApiUserController::index');
            $routes->get('deleted', 'ApiUserController::getAllDeletedUser');
            $routes->get('(:segment)', 'ApiUserController::getOne/$1');
            /** datatable */
            $routes->post('datatables', 'ApiUserController::datatables');
            /** create operation */
            $routes->post('/', 'ApiUserController::create');
            $routes->post('multiple', 'ApiUserController::createMultiple');
            /** update operation */
            $routes->put('(:segment)/update', 'ApiUserController::update/$1');
            /** delete operation */
            $routes->delete('(:segment)/delete', 'ApiUserController::delete/$1');
            $routes->delete('delete/multiple', 'ApiUserController::deleteMultiple');
            /** purge operation */
            $routes->delete('(:segment)/purge', 'ApiUserController::purge/$1');
            $routes->delete('purge/multiple', 'ApiUserController::purgeMultiple');
        });
    });
});