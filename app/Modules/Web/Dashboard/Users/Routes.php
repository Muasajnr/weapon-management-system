<?php

$routes->get('dashboard/users', $routeNamespace.'DefaultController::index', ['as' => 'users']);