<?php

$routes->group('dashboard/sarana_keamanan', ['namespace' => $routeNamespace], function($routes) {
    $routes->get('senjata_api', 'DefaultController::senjataApi', ['as' => 'senjata_api']);
    $routes->get('non_organik', 'DefaultController::nonOrganik', ['as' => 'non_organik']);
    $routes->get('lainnya', 'DefaultController::lainnya', ['as' => 'lainnya']);
});