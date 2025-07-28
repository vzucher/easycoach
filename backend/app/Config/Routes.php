<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = \Config\Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Basic home route
$routes->get('/', 'Home::index');

// API Routes for EasyCoach Challenge
$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
    // Players endpoints
    $routes->get('players', 'PlayerController::index');
    $routes->get('players/(:num)', 'PlayerController::show/$1');
    $routes->get('players/(:num)/sessions', 'PlayerController::sessions/$1');
    
    // Health check endpoint
    $routes->get('health', 'PlayerController::health');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
} 