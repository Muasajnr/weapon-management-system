<?php

// $routes->group('api', ['namespace' => '\App\Modules\Api\Controllers\\'], function($routes) {
    // $routes->post('login', 'ApiAuthController::handleLogin');
    // $routes->post('renew/token', 'ApiAuthController::renewAccessToken');
    // $routes->post('logout', 'ApiAuthController::handleLogout');

    /** dashboard */
    // $routes->group('dashboard', function($routes) {
    //     /**dashboard data */
    //     /**total barang masuk bulan ini */
    //     /**10 data terakhir yang diinput */
    //     /**list data berdasarkan jenis sarana dan jumlahnya */
        

    //     /**users */
    //     // $routes->group('users', function($routes) {
    //     //     /** get operation */
    //     //     // $routes->get('/', 'ApiUserController::index');
    //     //     // $routes->get('deleted', 'ApiUserController::getAllDeletedUser');
    //     //     // $routes->get('(:segment)', 'ApiUserController::getOne/$1');
    //     //     /** datatable */
    //     //     // $routes->post('datatables', 'ApiUserController::datatables');
    //     //     // $routes->post('datatables/history', 'ApiUserController:datatablesHistory');
    //     //     /** create operation */
    //     //     // $routes->post('/', 'ApiUserController::create');
    //     //     // $routes->post('multiple', 'ApiUserController::createMultiple');
    //     //     /** update operation */
    //     //     // $routes->put('(:segment)/update', 'ApiUserController::update/$1');
    //     //     /** delete operation */
    //     //     // $routes->delete('(:segment)/delete', 'ApiUserController::delete/$1');
    //     //     // $routes->delete('delete/multiple', 'ApiUserController::deleteMultiple');
    //     //     /** restore operation */
    //     //     // $routes->delete('(:segment)/restore', 'ApiUserController::restore/$1');
    //     //     // $routes->delete('restore/multiple', 'ApiUserController::restoreMultiple');
    //     //     /** purge operation */
    //     //     // $routes->delete('(:segment)/purge', 'ApiUserController::purge/$1');
    //     //     // $routes->delete('purge/multiple', 'ApiUserController::purgeMultiple');
    //     // });
    //     /**berita acara */
    //     // $routes->group('beritaacara', function($routes) {
    //     //     /** get operation */
    //     //     // $routes->get('/', 'ApiBeritaAcaraController::index');
    //     //     // $routes->get('deleted', 'ApiBeritaAcaraController::getAllDeletedUser');
    //     //     // $routes->get('(:segment)', 'ApiBeritaAcaraController::getOne/$1');
    //     //     /** datatable */
    //     //     $routes->post('datatables', 'ApiBeritaAcaraController::datatables');
    //     //     // $routes->post('datatables/history', 'ApiBeritaAcaraController:datatablesHistory');
    //     //     /** create operation */
    //     //     $routes->post('/', 'ApiBeritaAcaraController::create');
    //     //     // $routes->post('multiple', 'ApiUserController::createMultiple');
    //     //     /** update operation */
    //     //     // $routes->put('(:segment)/update', 'ApiBeritaAcaraController::update/$1');
    //     //     /** delete operation */
    //     //     // $routes->delete('(:segment)/delete', 'ApiBeritaAcaraController::delete/$1');
    //     //     // $routes->delete('delete/multiple', 'ApiBeritaAcaraController::deleteMultiple');
    //     //     /** restore operation */
    //     //     // $routes->delete('(:segment)/restore', 'ApiBeritaAcaraController::restore/$1');
    //     //     // $routes->delete('restore/multiple', 'ApiBeritaAcaraController::restoreMultiple');
    //     //     /** purge operation */
    //     //     // $routes->delete('(:segment)/purge', 'ApiBeritaAcaraController::purge/$1');
    //     //     // $routes->delete('purge/multiple', 'ApiBeritaAcaraController::purgeMultiple');
    //     // });
    //     /**master data */
    //     // $routes->group('master', function($routes) {
    //     //     /**jenis inventaris*/
    //     //     $routes->group('jenisinventaris', function($routes) {
    //     //         /** get operation */
    //     //         /** datatable */
    //     //         $routes->post('datatables', 'ApiJenisInventarisController::datatables');
    //     //         // $routes->post('datatables/history', 'ApiJenisInventarisController:datatablesHistory');
    //     //         /** create operation */
    //     //         /** update operation */
    //     //         /** delete operation */
    //     //         /** restore operation */
    //     //         /** purge operation */
    //     //     });
    //     //     /**jenis sarana */
    //     //     $routes->group('jenissarana', function($routes) {
    //     //         /** get operation */
    //     //         /** datatable */
    //     //         $routes->post('datatables', 'ApiJenisSaranaController::datatables');
    //     //         /** create operation */
    //     //         /** update operation */
    //     //         /** delete operation */
    //     //         /** restore operation */
    //     //         /** purge operation */
    //     //     });
    //     //     /**merk sarana */
    //     //     $routes->group('merksarana', function($routes) {
    //     //         /** get operation */
    //     //         /** datatable */
    //     //         $routes->post('datatables', 'ApiMerkInventarisController::datatables');
    //     //         /** create operation */
    //     //         /** update operation */
    //     //         /** delete operation */
    //     //         /** restore operation */
    //     //         /** purge operation */
    //     //     });
    //     // });
    //     /**sarana keamanan */
    //     // $routes->group('saranakeamanan', function($routes) {
    //     //     /** get operation */
    //     //     /** datatable */
    //     //     $routes->post('datatables', 'ApiSaranaKeamananController::datatables');
    //     //     /** create operation */
    //     //     /** update operation */
    //     //     /** delete operation */
    //     //     /** restore operation */
    //     //     /** purge operation */
    //     // });
    //     /**pinjam sarana */
    //     $routes->group('pinjam', function($routes) {
    //         /** get operation */
    //         /** datatable */
    //         $routes->post('datatables', 'ApiPinjamSaranaController::datatables');
    //         /** create operation */
    //         /** update operation */
    //         /** delete operation */
    //         /** restore operation */
    //         /** purge operation */
    //     });
    //     /**kembalikan sarana */
    //     $routes->group('kembalikan', function($routes) {
    //         /** get operation */
    //         /** datatable */
    //         $routes->post('datatables', 'ApiKembalikanSaranaController::datatables');
    //         /** create operation */
    //         /** update operation */
    //         /** delete operation */
    //         /** restore operation */
    //         /** purge operation */
    //     });
    //     /**distribusi sarana */
    //     $routes->group('distribusi', function($routes) {
    //         /** get operation */
    //         /** datatable */
    //         $routes->post('datatables', 'ApiDistribusiSaranaController::datatables');
    //         /** create operation */
    //         /** update operation */
    //         /** delete operation */
    //         /** restore operation */
    //         /** purge operation */
    //     });
    //     /**laporan */
    //     $routes->group('laporan', function($routes) {
    //         /** 
    //          * data chart sarana masuk by 
    //          *  -> hari ini,
    //          *  -> 24 jam terakhir 
    //          *  -> minggu ini
    //          *  -> 7 hari terakhir, 
    //          *  -> bulan ini
    //          *  -> 1 bulan terakhir, 
    //          *  -> tahun ini
    //          *  -> 1 tahun terakhir
    //          *  -> range by date
    //          *  */
    //         $routes->get('sarana/masuk/chart', 'ApiLaporanController::saranaMasukChart');
    //         /** 
    //          * data chart sarana dipinjam
    //          *  -> hari ini,
    //          *  -> 24 jam terakhir 
    //          *  -> minggu ini
    //          *  -> 7 hari terakhir, 
    //          *  -> bulan ini
    //          *  -> 1 bulan terakhir, 
    //          *  -> tahun ini
    //          *  -> 1 tahun terakhir
    //          *  -> range by date 
    //          * */
    //         $routes->get('sarana/dipinjam/chart', 'ApiLaporanController::saranaDipinjamChart');
    //         /**
    //          * data chart sarana dikembalikan
    //          * * 
    //          *  -> hari ini,
    //          *  -> 24 jam terakhir 
    //          *  -> minggu ini
    //          *  -> 7 hari terakhir, 
    //          *  -> bulan ini
    //          *  -> 1 bulan terakhir, 
    //          *  -> tahun ini
    //          *  -> 1 tahun terakhir
    //          *  -> range by date
    //          *  */
    //         $routes->get('sarana/dikembalikan/chart', 'ApiLaporanController::saranaDikembalikanChart');
    //         /** 
    //          * data chart sarana didistribusikan
    //          * * 
    //          *  -> hari ini,
    //          *  -> 24 jam terakhir 
    //          *  -> minggu ini
    //          *  -> 7 hari terakhir, 
    //          *  -> bulan ini
    //          *  -> 1 bulan terakhir, 
    //          *  -> tahun ini
    //          *  -> 1 tahun terakhir
    //          *  -> range by date
    //          *  */
    //         $routes->get('sarana/didistribusikan/chart', 'ApiLaporanController::saranaDidistribusikanChart');
    //     });
    //     /**stok */
    //     $routes->group('stok', function($routes) {
    //         /**get operation */
    //         $routes->get('(:segment)/detail', 'StokController::detail/$1');
    //         /**datatable */
    //         $routes->post('datatables', 'StokController::datatables');
    //     });
    // });
// });