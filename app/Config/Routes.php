<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rotas principais de visualização
$routes->get('/', 'Home::index');
$routes->get('/index', 'Home::index');
$routes->get('/cadastroAtividade', 'Home::cadastroAtividade');

// Processamento de autenticação e sessão
$routes->post('/login', 'Home::login');
$routes->get('/logout', 'Home::logout');

// Rotas exclusivas para interações assíncronas do Feed (JavaScript)
$routes->post('/toggleLike', 'Home::toggleLike');
$routes->post('/adicionarComentario', 'Home::adicionarComentario');