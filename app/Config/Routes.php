<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override('App\Controllers\Home::page404');
$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');


service('auth')->routes($routes);

$routes->group('', ['filter' => 'session'], static function ($routes) {
  $routes->get('dashboard', 'Admin\Dashboard::index');


  // $routes->group('users', ['filter' => 'myfilter2:region'], static function ($routes) {
  //     $routes->get('list', 'Admin\Users::list');
  // });
});