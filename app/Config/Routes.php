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
    $routes->post('login', 'AuthController::handleLogin');
    $routes->post('renew/token', 'AuthController::renewAccessToken');
    $routes->post('logout', 'AuthController::handleLogout');

    $routes->group('dashboard', function($routes) {
        // home

        // inventory types
        $routes->group('inventory-types', function($routes) {
            $routes->get('/', 'InventoryTypeController::index');
            $routes->get('(:segment)', 'InventoryTypeController::getOneData/$1');
            
            $routes->post('/', 'InventoryTypeController::create');
            $routes->post('datatables', 'InventoryTypeController::datatables');

            $routes->put('(:segment)/update/status', 'InventoryTypeController::updateStatus/$1');
            $routes->put('(:segment)/update', 'InventoryTypeController::update/$1');

            $routes->delete('(:segment)/delete', 'InventoryTypeController::delete/$1');
            $routes->delete('delete/multiple', 'InventoryTypeController::deleteMultiple');
            $routes->delete('(:segment)/purge', 'InventoryTypeController::purge/$1');
        });

        // firearms types
        $routes->group('firearms-types', function($routes) {
            $routes->get('/', 'FirearmTypeController::index');
            $routes->get('(:segment)', 'FirearmTypeController::getOneData/$1');
            
            $routes->post('/', 'FirearmTypeController::create');
            $routes->post('datatables', 'FirearmTypeController::datatables');

            $routes->put('(:segment)/update/status', 'FirearmTypeController::updateStatus/$1');
            $routes->put('(:segment)/update', 'FirearmTypeController::update/$1');

            $routes->delete('(:segment)/delete', 'FirearmTypeController::delete/$1');
            $routes->delete('delete/multiple', 'FirearmTypeController::deleteMultiple');
            $routes->delete('(:segment)/purge', 'FirearmTypeController::purge/$1');
        });

        // firearms brands
        $routes->group('firearms-brands', function($routes) {
            // $routes->get('/', 'FirearmTypeController::index');
            // $routes->get('(:segment)', 'FirearmTypeController::getOneData/$1');
            
            $routes->post('/', 'FirearmTypeController::create');
            $routes->post('datatables', 'FirearmBrandController::datatables');

            // $routes->put('(:segment)/update/status', 'FirearmTypeController::updateStatus/$1');
            // $routes->put('(:segment)/update', 'FirearmTypeController::update/$1');

            // $routes->delete('(:segment)/delete', 'FirearmTypeController::delete/$1');
            // $routes->delete('delete/multiple', 'FirearmTypeController::deleteMultiple');
            // $routes->delete('(:segment)/purge', 'FirearmTypeController::purge/$1');
        });

        // stocks
        $routes->group('stocks', function($routes) {
            $routes->post('datatables', 'FirearmStockController::datatables');
        });

        // firearms
        $routes->group('firearms', function($routes) {
            $routes->post('/', 'FirearmController::create');
            $routes->post('datatables', 'FirearmController::datatables');
        });

        // borrowings
        $routes->group('borrowings', function($routes) {
            $routes->post('/', 'BorrowingController::create');
            $routes->post('datatables', 'BorrowingController::datatables');
        });

        // returnings
        $routes->group('returnigs', function($routes) {
            $routes->post('/', 'ReturningController::create');
            $routes->post('datatables', 'ReturningController::datatables');
        });

        // documents
        $routes->group('documents', function($routes) {
            $routes->post('/', 'DocumentController::create');
            $routes->post('datatables', 'DocumentController::datatables');
        });

        // reports
        $routes->group('reports', function($routes) {
            $routes->post('datatables', 'ReportController::datatables');
        });

        // users
        $routes->group('users', function($routes) {
            $routes->post('datatables', 'UserController::datatables');
        });

    });
});

/** dashboard routes */
$routes->group('dashboard', ['namespace' => 'App\Controllers\Dashboard'], function($routes) {
    $routes->get('/', 'Index::index');
    $routes->get('home', 'Index::home', ['as' => 'home']);
    
    $routes->group('master', function($routes) {
        $routes->get('/', 'Index::master', ['as' => 'master']);
        $routes->get('jenis-inventaris', 'Index::inventory_types', ['as' => 'inventory_types']);
        $routes->get('jenis-senjata-api', 'Index::firearms_types', ['as' => 'firearms_types']);
        $routes->get('merk-senjata-api', 'Index::firearms_brands', ['as' => 'firearms_brands']);
    });

    $routes->get('stok', 'Index::stocks', ['as' => 'stocks']);
    $routes->get('senjata-api', 'Index::firearms', ['as' => 'firearms']);
    $routes->get('peminjaman', 'Index::borrowings', ['as' => 'borrowings']);
    $routes->get('pengembalian', 'Index::returnings', ['as' => 'returnings']);
    $routes->get('berita-acara', 'Index::documents', ['as' => 'documents']);
    $routes->get('laporan', 'Index::reports', ['as' => 'reports']);
    $routes->get('users', 'Index::users', ['as' => 'users']);
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
