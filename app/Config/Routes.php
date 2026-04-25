<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Route par défaut → page de login ──────────────────────────────────────
$routes->get('/', 'AuthController::login');

// ── Module 1 : Authentification ───────────────────────────────────────────
$routes->get('/login',  'AuthController::login');
$routes->post('/login', 'AuthController::doLogin');
$routes->get('/forgot-password', 'AuthController::forgotPassword');
$routes->post('/forgot-password', 'AuthController::sendResetLink');
$routes->get('/password-reset/(:segment)', 'AuthController::resetPassword/$1');
$routes->post('/password-reset', 'AuthController::doResetPassword');
$routes->get('/logout', 'AuthController::logout');

// ── Zone protégée (filtre auth appliqué dans Filters.php) ─────────────────
$routes->get('/dashboard', 'DashboardController::index');

// Route enseignant
$routes->get('/mon-planning', 'EnseignantController::planning');

// ── Futurs modules (à décommenter au fur et à mesure) ─────────────────────
// Module 2 : Ressources
// $routes->group('enseignants', ['filter' => 'auth'], function($routes) { ... });
// $routes->group('cours',       ['filter' => 'auth'], function($routes) { ... });
// $routes->group('salles',      ['filter' => 'auth'], function($routes) { ... });
// $routes->group('filieres',    ['filter' => 'auth'], function($routes) { ... });

// Module 3 : Construction EDT
// $routes->group('edt', ['filter' => 'auth'], function($routes) { ... });

// Module 4 : Consultation
// $routes->get('/edt/consulter', 'EdtController::consulter', ['filter' => 'auth']);
// $routes->get('/edt/export',    'EdtController::export',    ['filter' => 'auth']);

// Module 5 : Dashboard statistiques
// $routes->get('/statistiques', 'StatController::index', ['filter' => 'auth']);
// $routes->get('/historique',   'StatController::historique', ['filter' => 'auth']);
