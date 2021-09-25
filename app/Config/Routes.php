<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/login', 'Login::index');

/** restful api */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->post('login', 'AuthApi::handleLogin');
    $routes->post('renew/token', 'AuthApi::renewAccessToken');
    $routes->post('logout', 'AuthApi::handleLogout');

    $routes->group('dashboard', ['namespace' => 'App\Controllers\Api'], function($routes) {
        $routes->group('inventory-types', function($routes) {
            $routes->get('/', 'InventoryTypeApi::index');
            $routes->post('datatables', 'InventoryTypeApi::datatables');
            $routes->put('(:segment)/update/status', 'InventoryTypeApi::updateStatus/$1');
        });
    });
});

/** dashboard routes */
$routes->group('dashboard', ['namespace' => 'App\Controllers\Dashboard'], function($routes) {
    $routes->get('/', 'Index::index');
    $routes->get('home', 'Index::home', ['as' => 'home']);
    $routes->get('jenis-inventaris', 'Index::inventory_types', ['as' => 'inventory_types']);
    $routes->get('jenis-senjata-api', 'Index::firearms_types', ['as' => 'firearms_types']);
    $routes->get('merk-senjata-api', 'Index::firearms_brands', ['as' => 'firearms_brands']);
});

$routes->group('test', ['namespace' => 'App\Controllers\TestCIFeatures'], function($routes) {
    $routes->get('test_time_now', 'OnlyTest::testTimeNow');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
