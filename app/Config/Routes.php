<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Grupo de rutas para la tienda pública
$routes->group('', ['namespace' => 'App\Controllers\Tienda'], function ($routes) {
    $routes->get('/', 'Catalogo::index');
    $routes->get('catalogo', 'Catalogo::index');
    $routes->get('catalogo/categoria/(:segment)', 'Catalogo::categoria/$1');
    $routes->get('catalogo/buscar', 'Catalogo::buscar');
    $routes->get('producto/(:segment)', 'Catalogo::detalle/$1');
    $routes->addRedirect('producto', 'catalogo');

    // Carrito
    $routes->get('carrito', 'Carrito::index');
    $routes->post('carrito/agregar', 'Carrito::agregar');
    $routes->post('carrito/actualizar', 'Carrito::actualizar');
    $routes->post('carrito/eliminar', 'Carrito::eliminar');
    $routes->get('carrito/contador', 'Carrito::contador');

    // Checkout
    $routes->get('checkout', 'Checkout::index', ['filter' => 'auth']);
    $routes->post('checkout/procesar', 'Checkout::procesar', ['filter' => 'auth']);
    $routes->get('checkout/confirmacion/(:segment)', 'Checkout::confirmacion/$1', ['filter' => 'auth']);

    // Pedidos del cliente
    $routes->get('mis-pedidos', 'Pedidos::index', ['filter' => 'auth']);
    $routes->get('mis-pedidos/ver/(:segment)', 'Pedidos::ver/$1', ['filter' => 'auth']);
});

// Autenticación
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('registro', 'Auth::registro');
$routes->post('registro', 'Auth::doRegistro');
$routes->get('logout', 'Auth::logout');

// Grupo de rutas para administración
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    // Productos
    $routes->get('productos', 'Productos::index');
    $routes->get('productos/nuevo', 'Productos::nuevo');
    $routes->post('productos/guardar', 'Productos::guardar');
    $routes->get('productos/editar/(:num)', 'Productos::editar/$1');
    $routes->post('productos/actualizar/(:num)', 'Productos::actualizar/$1');
    $routes->post('productos/eliminar/(:num)', 'Productos::eliminar/$1');
    $routes->post('productos/cambiar-estado', 'Productos::cambiarEstado');

    // Categorías
    $routes->get('categorias', 'Categorias::index');
    $routes->post('categorias/guardar', 'Categorias::guardar');
    $routes->post('categorias/actualizar/(:num)', 'Categorias::actualizar/$1');
    $routes->post('categorias/eliminar/(:num)', 'Categorias::eliminar/$1');

    // Pedidos
    $routes->get('pedidos', 'Pedidos::index');
    $routes->get('pedidos/ver/(:num)', 'Pedidos::ver/$1');
    $routes->post('pedidos/cambiar-estado', 'Pedidos::cambiarEstado');
    $routes->get('pedidos/imprimir/(:num)', 'Pedidos::imprimir/$1');

    // Clientes
    $routes->get('clientes', 'Clientes::index');
    $routes->get('clientes/ver/(:num)', 'Clientes::ver/$1');

    // Reportes
    $routes->get('reportes', 'Reportes::index');
    $routes->get('reportes/ventas', 'Reportes::ventas');
    $routes->get('reportes/productos', 'Reportes::productos');
    $routes->get('reportes/exportar/(:segment)', 'Reportes::exportar/$1');


    // Perfil
    $routes->get('perfil', 'Perfil::index');
    $routes->post('perfil/actualizar', 'Perfil::actualizar');
});
