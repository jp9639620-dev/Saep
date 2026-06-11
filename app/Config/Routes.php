<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->get('/', 'Home::index');

// Auth routes (controllers implemented as AuthController)
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Activities routes (protected by auth filter)
$routes->get('atividades', 'AtividadeController::index');
$routes->post('atividades/criar', 'AtividadeController::criar');
$routes->post('atividades/deletar', 'AtividadeController::deletar');

// keep legacy routes if needed
$routes->get('index', 'Home::index');
$routes->post('autenticar', 'Home::autenticar');
$routes->post('home/curtir', 'Home::curtir');
$routes->get('atividade', 'Home::cadastroAtividade');
$routes->post('atividade/salvar', 'Atividade::salvar');
$routes->post('curtir/toggle', 'Curtida::toggle');
$routes->post('comentario/salvar', 'Comentario::salvar');
