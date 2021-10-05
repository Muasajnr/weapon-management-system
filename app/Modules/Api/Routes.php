<?php

$routes->group('api', ['namespace' => '\App\Modules\Api\Controllers\\'], function($routes) {
    $routes->post('login', 'ApiAuthController::handleLogin');
    $routes->post('renew/token', 'ApiAuthController::renewAccessToken');
    $routes->post('logout', 'ApiAuthController::handleLogout');

    /** dashboard */
    $routes->group('dashboard', function($routes) {
        /**users */
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
        /**berita acara */
        $routes->group('beritaacara', function($routes) {
            
        });
        /**master data */
        $routes->group('master', function($routes) {
            /**jenis inventaris*/
            $routes->group('jenisinventaris', function($routes) {
                
            });
            /**jenis sarana */
            $routes->group('jenissarana', function($routes) {
                
            });
            /**merk sarana */
            $routes->group('merksarana', function($routes) {
                
            });
        });
        /**sarana keamanan */
        $routes->group('saranakeamanan', function($routes) {

        });
        /**pinjam sarana */
        $routes->group('pinjam', function($routes) {

        });
        /**kembalikan sarana */
        $routes->group('kembalikan', function($routes) {

        });
        /**distribusi sarana */
        $routes->group('distribusi', function($routes) {
                
        });
        /**laporan */
        $routes->group('laporan', function($routes) {
                
        });
        /**stok */
        $routes->group('stok', function($routes) {
                
        });
    });
});