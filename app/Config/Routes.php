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


// ------ Module 2 : Ressources------

// Routes Filières
$routes->group('filieres', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'FiliereController::index');
    $routes->get('create', 'FiliereController::create');
    $routes->post('store', 'FiliereController::store');
    $routes->get('edit/(:num)', 'FiliereController::edit/$1');
    $routes->post('update/(:num)', 'FiliereController::update/$1');
    $routes->get('delete/(:num)', 'FiliereController::delete/$1');
});

// Enseignants
$routes->group('enseignants', ['filter' => 'auth'], function($routes) {
    $routes->get('/',                   'EnseignantController::index');
    $routes->get('create',              'EnseignantController::create');
    $routes->post('store',              'EnseignantController::store');
    $routes->get('edit/(:num)',         'EnseignantController::edit/$1');
    $routes->post('update/(:num)',      'EnseignantController::update/$1');
    $routes->get('delete/(:num)',       'EnseignantController::delete/$1');
});

// Salles
$routes->group('salles', ['filter' => 'auth'], function($routes) {
    $routes->get('/',                   'SalleController::index');
    $routes->get('create',              'SalleController::create');
    $routes->post('store',              'SalleController::store');
    $routes->get('edit/(:num)',         'SalleController::edit/$1');
    $routes->post('update/(:num)',      'SalleController::update/$1');
    $routes->get('delete/(:num)',       'SalleController::delete/$1');
});

// Cours
$routes->group('cours', ['filter' => 'auth'], function($routes) {
    $routes->get('/',                   'CoursController::index');
    $routes->get('create',              'CoursController::create');
    $routes->post('store',              'CoursController::store');
    $routes->get('edit/(:num)',         'CoursController::edit/$1');
    $routes->post('update/(:num)',      'CoursController::update/$1');
    $routes->get('delete/(:num)',       'CoursController::delete/$1');
});

// Disponibilités
$routes->group('disponibilites', ['filter' => 'auth'], function($routes) {
    $routes->get('/',                   'DisponibiliteController::index');
    $routes->get('create',              'DisponibiliteController::create');
    $routes->post('store',              'DisponibiliteController::store');
    $routes->get('edit/(:num)',         'DisponibiliteController::edit/$1');
    $routes->post('update/(:num)',      'DisponibiliteController::update/$1');
    $routes->get('delete/(:num)',       'DisponibiliteController::delete/$1');
});

// Module 3 : Construction EDT
$routes->group('edt', ['filter' => 'auth'], function($routes) {
 
    $routes->get('/',                        'EdtController::index');
    $routes->get('semaine/(:segment)',       'EdtController::index/$1');
 
    $routes->get('create',                   'EdtController::create');
    $routes->post('store',                   'EdtController::store');
 
    $routes->get('edit/(:num)',              'EdtController::edit/$1');
    $routes->post('update/(:num)',           'EdtController::update/$1');
 
    $routes->get('delete/(:num)',            'EdtController::delete/$1');
 
    $routes->post('check-conflicts',         'EdtController::checkConflicts');
 
    $routes->get('cours-par-filiere/(:num)', 'EdtController::coursParFiliere/$1');
});

// Module 4 : Consultation
$routes->group('consultation', ['filter' => 'auth'], function($routes) {
    $routes->get('/',    'ConsultationController::index');
    $routes->get('pdf',  'ConsultationController::exportPdf');
});

// Module 5 : Dashboard statistiques
// $routes->get('/statistiques', 'StatController::index', ['filter' => 'auth']);
// $routes->get('/historique',   'StatController::historique', ['filter' => 'auth']);
