<?php

use App\Controllers\BsFormDemo;
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
$routes->get('demo', function () {

  // $cleanTitle = urldecode(String $page);

  // 2. Assign it to the data array
  $data = [
    'pageTitle' => urldecode($_GET['t'])
  ];

  return view('admin/dashboard/demopage', $data);
});



service('auth')->routes($routes);

$routes->group("bsformdemo", static function ($routes) {
  $routes->get('/', 'BsFormDemo');
  $routes->post('submit', 'BsFormDemo::submit');
});

$routes->group("user", ['filter' => 'session'], static function ($routes) {
  $routes->get('home', 'Admin\UserController::index', ['as' => 'user.home']);
  $routes->get('profile', 'Admin\UserController::profile', ['as' => 'user.profile']);
  $routes->get('permissionDenied', 'Admin\UserController::permissionDenied', ['as' => 'permissiondenied']);
  $routes->get('passwordReset', 'Admin\UserController::passwordReset', ['as' => 'user.passwordreset']);
  $routes->post('savePassword', 'Admin\UserController::savePassword', ['as' => 'user.savepwd']);
});

$routes->group("admin", ['filter' => 'group:superadmin'], static function ($routes) {
  $routes->get('listUsers', 'Admin\UserController::listUsers', ['as' => 'list.users']);
  $routes->post('add', 'Admin\UserController::add', ['as' => 'add.user']);
  $routes->post('update', 'Admin\UserController::update', ['as' => 'update.user']);
  $routes->post('delete', 'Admin\UserController::delete', ['as' => 'delete.user']);
  $routes->get('getAllUsers', 'Admin\UserController::getAllUsers', ['as' => 'get.all.users']);
  $routes->post('getUserInfo', 'Admin\UserController::getUserInfo', ['as' => 'get.user.info']);
  $routes->post('disableUser', 'Admin\UserController::disableUser', ['as' => 'disable.user']);
});

$routes->group('backup', ['filter' => 'session'], static function ($routes) {
  $routes->get('/', 'Admin\Backup::index');
  $routes->post('create', 'Admin\Backup::create');
  $routes->get('download/(:segment)', 'Admin\Backup::download/$1');
  $routes->post('delete/(:any)', 'Admin\Backup::delete/$1', ['as' => 'Backup::delete']);
});

$routes->group('', ['filter' => 'session'], static function ($routes) {
  $routes->get('dashboard', 'Admin\Dashboard::index');


  // $routes->group('users', ['filter' => 'myfilter2:region'], static function ($routes) {
  //     $routes->get('list', 'Admin\Users::list');
  // });
});