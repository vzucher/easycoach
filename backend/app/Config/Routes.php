<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
  // Players endpoints
  $routes->get('players', 'PlayerController::index');
  $routes->get('players/(:num)', 'PlayerController::show/$1');
  $routes->get('players/(:num)/sessions', 'PlayerController::sessions/$1');
  
  // Health check endpoint
  $routes->get('health', 'PlayerController::health');
});

