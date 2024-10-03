<?php

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/*
 * The default class to use for all routes
 */

Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true,
    ]));

    /*
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered through `Application::routes()` with `registerMiddleware()`
     */
    $routes->applyMiddleware('csrf');

    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /*
     * Connecting specific routes for Users controller (using 'usuarios' in the URL).
     */
    // Rutas para el controlador Users, usando "token" en lugar de "id"
    $routes->connect('/usuarios', ['controller' => 'Users', 'action' => 'index']);
    $routes->connect('/usuarios/agregar', ['controller' => 'Users', 'action' => 'add']);
    $routes->connect('/usuarios/ver/:token', ['controller' => 'Users', 'action' => 'view'], ['pass' => ['token'], 'token' => '[a-zA-Z0-9\-]+']);
    $routes->connect('/usuarios/editar/:token', ['controller' => 'Users', 'action' => 'edit'], ['pass' => ['token'], 'token' => '[a-zA-Z0-9\-]+']);
    $routes->connect('/usuarios/eliminar/:token', ['controller' => 'Users', 'action' => 'delete'], ['pass' => ['token'], 'token' => '[a-zA-Z0-9\-]+']);

    // Rutas específicas para el controlador Courses (usando 'cursos' en la URL), también utilizando token
    $routes->connect('/cursos', ['controller' => 'Courses', 'action' => 'index']);
    $routes->connect('/cursos/agregar', ['controller' => 'Courses', 'action' => 'add']);
    $routes->connect('/cursos/ver/:token', ['controller' => 'Courses', 'action' => 'view'], ['pass' => ['token'], 'token' => '[a-zA-Z0-9\-]+']);
    $routes->connect('/cursos/editar/:token', ['controller' => 'Courses', 'action' => 'edit'], ['pass' => ['token'], 'token' => '[a-zA-Z0-9\-]+']);
    $routes->connect('/cursos/eliminar/:token', ['controller' => 'Courses', 'action' => 'delete'], ['pass' => ['token'], 'token' => '[a-zA-Z0-9\-]+']);
    $routes->connect('/cursos/gestionar/*', ['controller' => 'Courses', 'action' => 'manage']);
    $routes->connect('/cursos/inscribirEstudiante/*', ['controller' => 'Courses', 'action' => 'enrollStudent']);
    $routes->connect('/cursos/eliminarEstudiante/*', ['controller' => 'Courses', 'action' => 'removeStudent']);
    $routes->connect('/cursos/detalles/:token', ['controller' => 'Courses', 'action' => 'getCourseDetails'], ['pass' => ['token'], 'token' => '[a-zA-Z0-9\-]+']);
    $routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotpassword']);
    $routes->connect('/reset-password/*', ['controller' => 'Users', 'action' => 'resetpassword']);
    

    /*
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
     * $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
     * ```
     */
    $routes->fallbacks(DashedRoute::class);
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * Router::scope('/api', function (RouteBuilder $routes) {
 *     // No $routes->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
