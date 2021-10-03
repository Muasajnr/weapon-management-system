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
        $routes->get('/cards', 'HomeController::cardsData()');
        $routes->get('/stock-by-inventory-type', 'HomeController::stockByInventoryType()');
        $routes->get('/stock-by-firearm-type', 'HomeController::stockByFirearmType()');
        $routes->get('/stock-by-firearm-brand', 'HomeController::stockByFirearmBrand()');
        $routes->get('/top-10-firearm', 'HomeController::top10Firearm');
        $routes->get('/top-10-borrowed-firearm', 'HomeController::top10BorrowedFirearm');

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
            $routes->get('/', 'FirearmBrandController::index');
            // $routes->get('(:segment)', 'FirearmBrandController::getOneData/$1');
            
            $routes->post('/', 'FirearmBrandController::create');
            $routes->post('datatables', 'FirearmBrandController::datatables');

            $routes->put('(:segment)/update/status', 'FirearmBrandController::updateStatus/$1');
            $routes->put('(:segment)/update', 'FirearmBrandController::update/$1');

            $routes->delete('(:segment)/delete', 'FirearmBrandController::delete/$1');
            $routes->delete('delete/multiple', 'FirearmBrandController::deleteMultiple');
            // $routes->delete('(:segment)/purge', 'FirearmBrandController::purge/$1');
        });

        // stocks
        $routes->group('stocks', function($routes) {
            $routes->post('datatables', 'FirearmStockController::datatables');
        });

        // firearms
        $routes->group('firearms', function($routes) {
            $routes->post('/', 'FirearmController::create');
            $routes->post('datatables', 'FirearmController::datatables');

            $routes->put('(:segment)/update', 'FirearmController::update/$1');

            $routes->delete('(:segment)/delete', 'FirearmController::delete/$1');
            $routes->delete('delete/multiple', 'FirearmController::deleteMultiple');
        });

        // borrowings
        $routes->group('borrowings', function($routes) {
            $routes->get('/history', 'BorrowingController::getDeleted');

            $routes->post('/', 'BorrowingController::create');
            $routes->post('datatables', 'BorrowingController::datatables');

            // $routes->put('(:segment)/update', 'FirearmController::update/$1');
            
            // $routes->delete('(:segment)/delete', 'FirearmBrandController::delete/$1');
            // $routes->delete('delete/multiple', 'FirearmBrandController::deleteMultiple');
        });

        // returnings
        $routes->group('returnings', function($routes) {
            $routes->post('/', 'ReturningController::create');
            $routes->post('datatables', 'ReturningController::datatables');

            // $routes->put('(:segment)/update', 'FirearmController::update/$1');
            
            // $routes->delete('(:segment)/delete', 'FirearmBrandController::delete/$1');
            // $routes->delete('delete/multiple', 'FirearmBrandController::deleteMultiple');
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
            $routes->get('/', 'UserController::index');
            $routes->get('(:segment)', 'UserController::getOneData/$1');
            
            $routes->post('/', 'UserController::create');
            $routes->post('datatables', 'UserController::datatables');

            $routes->put('(:segment)/update/status', 'UserController::updateStatus/$1');
            $routes->put('(:segment)/update', 'UserController::update/$1');

            $routes->delete('(:segment)/delete', 'UserController::delete/$1');
            $routes->delete('delete/multiple', 'UserController::deleteMultiple');
            // $routes->delete('(:segment)/purge', 'FirearmTypeController::purge/$1');
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

    $routes->group('senjata-api', function($routes) {
        $routes->get('/', 'Index::firearms', ['as' => 'firearms']);
        $routes->get('create', 'Index::firearms_add', ['as' => 'firearms_add']);
        $routes->get('(:segment)/edit', 'Index::firearms_edit/$1', ['as' => 'firearms_edit']);
    });
    
    $routes->group('peminjaman', function($routes) {
        $routes->get('sedang-dipinjam', 'Index::borrowings_ongoing', ['as' => 'borrowings_ongoing']);
        $routes->get('histori', 'Index::borrowings_history', ['as' => 'borrowings_ongoing']);
        $routes->get('create', 'Index::borrowings_add', ['as' => 'borrowings_add']);
        $routes->get('(:segment)/edit', 'Index::borrowings_edit/$1', ['as' => 'borrowings_edit']);
    });

    $routes->group('pengembalian', function($routes) {
        $routes->get('/', 'Index::returnings', ['as' => 'returnings']);
        $routes->get('create', 'Index::returnings_add', ['as' => 'returnings_add']);
        $routes->get('(:segment)/edit', 'Index::returnings_edit/$1', ['as' => 'returnings_edit']);
    });

    $routes->group('berita-acara', function($routes) {
        $routes->get('/', 'Index::documents', ['as' => 'documents']);
        $routes->get('create', 'Index::documents_add', ['as' => 'documents_add']);
        $routes->get('(:segment)/edit', 'Index::documents_edit/$1', ['as' => 'documents_edit']);
    });

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
