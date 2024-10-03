<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
    
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ],
                    'passwordHasher' => 'Default' // Hash por defecto para contraseñas
                ]
            ],
            'authorize' => ['Controller'], // Autorizar utilizando el método isAuthorized de cada controlador
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => false
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => false
            ],
            'authError' => 'Por favor, inicia sesión para acceder a esta área.',
            'unauthorizedRedirect' => $this->referer(), // Redirigir a la última página visitada si no autorizado
            'storage' => 'Session', // Utilizar sesión para almacenar datos de autenticación
        ]);
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // Permitir acceso sin autenticación a las siguientes acciones
        $this->Auth->allow(['login', 'logout']);
    }
    public function beforeRender(EventInterface $event)
{
    parent::beforeRender($event);
    $this->response = $this->response
        ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->withHeader('Pragma', 'no-cache')
        ->withHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
}

}
