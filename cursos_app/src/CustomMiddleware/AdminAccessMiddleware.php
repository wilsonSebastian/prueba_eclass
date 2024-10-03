<?php
namespace App\CustomMiddleware;

use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;

class AdminAccessMiddleware
{
    public function __invoke(ServerRequest $request, Response $response, callable $next)
    {
        $session = $request->getSession();
        $user = $session->read('Auth.User');

        // Verificar si el usuario está logueado y tiene rol 'user'
        if ($user && isset($user['role']) && $user['role'] === 'user') {
            // Comprobar si la ruta solicitada es parte del área de administrador
            $adminPrefixes = ['/admin'];  // Ruta que corresponde a la sección de administrador
            $currentPath = $request->getPath();

            foreach ($adminPrefixes as $prefix) {
                if (strpos($currentPath, $prefix) === 0) {
                    // Redirigir al usuario no autorizado al dashboard
                    return $response->withLocation(Router::url(['controller' => 'Users', 'action' => 'dashboard']));
                }
            }
        }

        return $next($request, $response);
    }
}
