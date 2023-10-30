<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Registro::index');
// $routes->post('login', 'Registro::login');
$routes->get('logout', 'Registro::logout');

// $routes->get('peliculas', 'Pelicula::index');
// $routes->get('peliculas/new', 'Pelicula::create');
// $routes->get('peliculas/edit/(:num)', 'Pelicula::edit'/$1);

$routes->presenter('peliculas', ['controller' => 'Pelicula']);
$routes->resource('registro');

service('auth')->routes($routes);

$routes->group('resources', ['filter' => 'basicAuthFilter'], function($routes){
    $routes->resource('cursos');
    $routes->get('cliente/(:num)/', 'Clientes::getClient/$1');
});

$routes->group('dashboard', ['filter' => 'DashboardFilter'], function($routes){
    $routes->get('usuario/crear', '\App\Controllers\Web\Usuario::create_user', ['as' => 'usuario.create_user']);
    $routes->get('usuario/test_password/(:num)', '\App\Controllers\Web\Usuario::test_password/$1', ['as' => 'usuario.test_pw']);
    $routes->get('peliculas', 'Pelicula::index', ['as' => 'pelicula.index']);
});


$routes->get('logingg', '\App\Controllers\Web\Usuario::login', ['as' => 'usuario.login']);
$routes->post('logingg', '\App\Controllers\Web\Usuario::login_post', ['as' => 'usuario.login_post']);