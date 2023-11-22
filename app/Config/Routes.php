<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingpageController::index');
$routes->get('/register', 'LoginController::register');
$routes->get('/login', 'LoginController::login');
$routes->get('/dashboards', 'LoginController::dashboards');
$routes->get('/farmerdashboard', 'DashboardController::farmerdashboard');