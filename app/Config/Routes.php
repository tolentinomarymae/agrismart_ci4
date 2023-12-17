<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingpageController::index');
$routes->get('/dashboards', 'LoginController::dashboards', ['filter' => 'authGuard']);
$routes->post('/register', 'LoginController::register');
$routes->get('/registerview', 'LoginController::registerview');
$routes->get('/sign_ins', 'LoginController::login');
$routes->post('/loginauth', 'LoginController::loginauth');
$routes->match(['post', 'get'], '/dashboards', 'LoginController::dashboards', ['filter' => 'authGuard']);
$routes->get('/admindashboard', 'LoginController::admindashboard', ['filter' => 'authGuard']);

//fields
$routes->get('/viewfields', 'DashboardController::viewfields');
$routes->post('/addfield', 'DashboardController::addnewfield');
$routes->post('/viewfields/edit/(:num)', 'DashboardController::edit/$1');
$routes->post('/viewfields/update', 'DashboardController::update');
$routes->post('viewfields/delete/(:num)', 'DashboardController::deleteProduct/$1');

// crop planting
$routes->get('/cropplanting', 'DashboardController::cropplanting');
$routes->post('/addplanting', 'DashboardController::addnewplanting');
$routes->post('/cropplanting/edit/(:num)', 'DashboardController::editplanting/$1');
$routes->post('/cropplanting/update', 'DashboardController::updateplanting');
$routes->post('cropplanting/delete/(:num)', 'DashboardController::deleteplanting/$1');

//jobs
$routes->get('/jobs', 'DashboardController::jobs', ['filter' => 'authGuard']);
$routes->post('/addjob', 'DashboardController::addnewjob');
$routes->post('/jobs/edit/(:num)', 'DashboardController::editjob/$1');
$routes->post('/jobs/update', 'DashboardController::updatejob');
$routes->post('jobs/delete/(:num)', 'DashboardController::deleteJob/$1');

//harvest
$routes->get('/harvest', 'DashboardController::harvest', ['filter' => 'authGuard']);
$routes->post('/addharvest', 'DashboardController::addnewharvest');
$routes->post('/harvest/edit/(:num)', 'DashboardController::editharvest/$1');
$routes->post('/harvest/update', 'DashboardController::updateharvest');
$routes->post('harvest/delete/(:num)', 'DashboardController::deleteHarvest/$1');

// worker
$routes->get('/workers', 'DashboardController::worker', ['filter' => 'authGuard']);
$routes->post('/addworker', 'DashboardController::addnewworker');
$routes->post('/workers/edit/(:num)', 'DashboardController::editworker/$1');
$routes->post('/workers/update', 'DashboardController::updateworker');
$routes->post('workers/delete/(:num)', 'DashboardController::deleteworker/$1');
