<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingpageController::index');
$routes->get('/dashboards', 'LoginController::dashboards', ['filter'=>'authGuard']);
$routes->get('/farmerdashboard', 'DashboardController::farmerdashboard');
$routes->post('/register', 'LoginController::register');
$routes->get('/registerview', 'LoginController::registerview');
$routes->get('/sign_ins', 'LoginController::login');
$routes->post('/loginauth', 'LoginController::loginauth');
$routes->match(['post', 'get'], '/dashboards', 'LoginController::dashboards',['filter'=>'authGuard']);
$routes->get('/croprotation', 'LoginController::croprotation');
$routes->get('/jobs', 'LoginController::jobs', ['filter'=>'authGuard']);
$routes->get('/admindashboard', 'LoginController::admindashboard', ['filter'=>'authGuard']);


