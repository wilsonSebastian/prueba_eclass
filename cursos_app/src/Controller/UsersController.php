<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\Utility\Text;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Http\Exception\NotFoundException;

class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Mensajes de notificación
        $this->loadComponent('RequestHandler');
        $this->loadModel('Users'); // Cargar el modelo Users
        $this->loadModel('Courses'); // Cargar el modelo Courses
        $this->loadModel('UsersCourses'); // Cargar el modelo de la tabla intermedia
    }

    
    // Método para restablecer la contraseña olvidada (Solicitar enlace)
    public function forgotPassword()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $user = $this->Users->findByEmail($email)->first();

            if ($user) {
                // Generar un token único para el restablecimiento
                $user->reset_token = Security::hash(Text::uuid(), 'sha256', true);
                $user->token_created_at = date('Y-m-d H:i:s');

                if ($this->Users->save($user)) {
                    // Enviar correo al usuario con el enlace de restablecimiento
                    $resetLink = Router::url([
                        'controller' => 'Users',
                        'action' => 'resetPassword',
                        $user->reset_token
                    ], true);

                    // Enviar el correo
                    $email = new Email('default');
                    $email->setTo($user->email)
                        ->setSubject('Restablecimiento de Contraseña')
                        ->send("Por favor, haga clic en el siguiente enlace para restablecer su contraseña: " . $resetLink);

                    $this->Flash->success(__('El enlace de restablecimiento de contraseña ha sido enviado a su correo.'));
                    return $this->redirect(['action' => 'login']);
                }
            } else {
                $this->Flash->error(__('No se encontró un usuario con ese correo electrónico.'));
            }
        }
    }

    // Método para restablecer la contraseña (establecer nueva contraseña)
    public function resetPassword($token = null)
    {
        if (!$token) {
            throw new NotFoundException(__('Token no válido'));
        }

        $user = $this->Users->find('all', [
            'conditions' => [
                'reset_token' => $token,
                'token_created_at >=' => date('Y-m-d H:i:s', strtotime('-1 day')) // Validez del token de 1 día
            ]
        ])->first();

        if (!$user) {
            $this->Flash->error(__('El token de restablecimiento no es válido o ha expirado.'));
            return $this->redirect(['action' => 'forgotPassword']);
        }

        if ($this->request->is(['post', 'put'])) {
            // Actualizar la contraseña y limpiar el token
            $user = $this->Users->patchEntity($user, [
                'password' => $this->request->getData('password'),
                'reset_token' => null,
                'token_created_at' => null
            ]);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Su contraseña ha sido restablecida con éxito.'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('No se pudo restablecer la contraseña. Por favor, inténtelo de nuevo.'));
            }
        }

        $this->set(compact('token'));
    }

    // Método de login de usuario
    public function login()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
    
            // Buscar al usuario por nombre de usuario
            $user = $this->Users->find('all', [
                'conditions' => ['username' => $data['username']]
            ])->first();
    
            if ($user) {
                // Verificar si el usuario está inactivo
                if ($user->status === 'inactive') {
                    $this->Flash->error(__('Tu cuenta está inactiva. Por favor, contacta al administrador.'));
                } else {
                    // Verificar la contraseña utilizando DefaultPasswordHasher
                    $hasher = new DefaultPasswordHasher();
                    if ($hasher->check($data['password'], $user->password)) {
                        // Guardar la información del usuario en la sesión
                        $this->request->getSession()->write('Auth.User', $user);
                        $this->Flash->success(__('Bienvenido, ' . $user->username));
                        return $this->redirect(['action' => 'dashboard']);
                    } else {
                        $this->Flash->error(__('Usuario o contraseña incorrectos.'));
                    }
                }
            } else {
                $this->Flash->error(__('Usuario o contraseña incorrectos.'));
            }
        }
    
        if ($this->request->getSession()->check('Auth.User')) {
            return $this->redirect(['action' => 'dashboard']);
        }
    }
    

    // Método de logout
    public function logout()
    {
        $session = $this->request->getSession();
        $session->delete('Auth.User'); // Eliminar la información del usuario de la sesión
        $this->Flash->success(__('Has cerrado sesión exitosamente.'));
        return $this->redirect(['action' => 'login']);
    }

    // Método del dashboard
// Método del dashboard
public function dashboard()
{
    if (!$this->request->getSession()->check('Auth.User')) {
        $this->Flash->error(__('No tienes permisos para acceder.'));
        return $this->redirect(['action' => 'login']);
    }

    $user = $this->request->getSession()->read('Auth.User'); // Obtener información del usuario logueado

    if ($user['role'] === 'admin') {
        // Si el usuario es administrador, carga los datos adicionales para administrar
        $users = $this->Users->find('all');
        $courses = $this->Courses->find('all');
        $this->set(compact('users', 'courses'));
    } else {
        // Si el usuario es regular, buscar los cursos donde está inscrito
        $courseName = $this->request->getQuery('course_name'); // Obtener el nombre del curso buscado

        $enrolledCoursesQuery = $this->UsersCourses->find()
            ->where(['user_id' => $user['id']])
            ->contain(['Courses.Users']); // Asegurar que se contenga la información del curso y sus usuarios

        // Filtrar los cursos por nombre si se ha proporcionado
        if ($courseName) {
            $enrolledCoursesQuery = $enrolledCoursesQuery->matching('Courses', function ($q) use ($courseName) {
                return $q->where(['Courses.name LIKE' => '%' . $courseName . '%']);
            });
        }

        $enrolledCourses = $enrolledCoursesQuery->extract('course')->toList();
        $this->set(compact('enrolledCourses'));
    }

    $this->set(compact('user')); // Pasar la información del usuario a la vista
}

 // Método que se ejecuta antes de cada acción
 public function beforeFilter(\Cake\Event\EventInterface $event)
 {
     parent::beforeFilter($event);
     
     // Permitir acceso a las siguientes acciones sin estar logueado
     $this->Auth->allow(['forgotpassword', 'resetpassword', 'login']);
 }



    // Método de autorización
  // Método de autorización
  public function isAuthorized($user)
  {
      // Los administradores tienen acceso a todas las acciones
      if (isset($user['role']) && $user['role'] === 'admin') {
          return true;
      }

      // Los usuarios regulares solo pueden acceder a ciertas acciones
      $allowedActionsForUser = ['dashboard', 'logout', 'forgotpassword', 'resetpassword'];
      
      if (isset($user['role']) && $user['role'] === 'user') {
          if (in_array($this->request->getParam('action'), $allowedActionsForUser)) {
              return true;
          }
      }

      // Acciones permitidas sin iniciar sesión
      $allowedUnauthenticatedActions = ['forgotpassword', 'resetpassword', 'login'];
      if (in_array($this->request->getParam('action'), $allowedUnauthenticatedActions)) {
          return true;
      }

      // Si el usuario no tiene permiso para la acción solicitada, mostrar mensaje de error y redirigir
      $this->Flash->error(__('No tienes permisos para acceder a esta área.'));
      return false;
  }


    // Listar todos los usuarios
    public function index()
    {
        $searchKeyword = $this->request->getQuery('search');
        $conditions = [];

        if ($searchKeyword) {
            // Agregar condiciones para la búsqueda
            $conditions['Users.username LIKE'] = '%' . $searchKeyword . '%';
        }

        $this->paginate = [
            'conditions' => $conditions,
            'limit' => 10,
        ];

        $users = $this->paginate($this->Users);

        // Si la solicitud es AJAX, renderizar solo el elemento 'users_table'
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $this->set(compact('users'));
            return $this->render('/Element/users_table');
        }

        $this->set(compact('users', 'searchKeyword'));
    }

    // Ver detalles de un usuario específico
    public function view($token = null)
    {
        $user = $this->Users->findByToken($token)->contain(['Courses'])->firstOrFail();
        $this->set('user', $user);
    }

    // Agregar un nuevo usuario
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    // Editar un usuario existente
    public function edit($token = null)
    {
        $user = $this->Users->findByToken($token)->firstOrFail();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be updated. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    // Eliminar un usuario
    public function delete($token = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->findByToken($token)->firstOrFail();
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    // Método para inscribir un usuario en un curso (solo admin)
    public function enroll()
    {
        // Solo los administradores pueden acceder a esta acción
        if (!$this->request->getSession()->read('Auth.User.role') === 'admin') {
            $this->Flash->error(__('No tienes permisos para acceder a esta área.'));
            return $this->redirect(['action' => 'dashboard']);
        }

        // Obtener todos los usuarios y cursos para mostrarlos en el formulario de inscripción
        $users = $this->Users->find('list');
        $courses = $this->Courses->find('list');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $userId = $data['user_id'];
            $courseId = $data['course_id'];

            // Crear la entidad UsersCourses
            $enrollment = $this->UsersCourses->newEntity([
                'user_id' => $userId,
                'course_id' => $courseId,
            ]);

            if ($this->UsersCourses->save($enrollment)) {
                $this->Flash->success(__('Usuario inscrito correctamente en el curso.'));
                return $this->redirect(['action' => 'dashboard']);
            } else {
                $this->Flash->error(__('No se pudo inscribir al usuario en el curso. Por favor, intenta nuevamente.'));
            }
        }

        $this->set(compact('users', 'courses'));
    }
    
    public function bulkUpload()
{
    if ($this->request->is('post')) {
        $file = $this->request->getData('file');
        
        if ($file['type'] == 'text/csv' || $file['type'] == 'application/vnd.ms-excel') {
            $csvFile = fopen($file['tmp_name'], 'r');
            $header = fgetcsv($csvFile); // Leer el encabezado

            while (($row = fgetcsv($csvFile)) !== false) {
                // Asumiendo que las columnas están en el orden correcto
                $data = array_combine($header, $row);
                
                // Crear entidad de usuario
                $user = $this->Users->newEntity([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'status' => $data['status'],
                    'password' => password_hash($data['password'], PASSWORD_DEFAULT)
                ]);

                // Guardar el usuario
                if ($this->Users->save($user)) {
                    // Mensaje de éxito o alguna acción adicional
                } else {
                    // Manejo del error, quizás almacenar los errores para mostrar después
                }
            }

            fclose($csvFile);
            $this->Flash->success(__('Usuarios cargados exitosamente.'));
        } else {
            $this->Flash->error(__('Por favor, suba un archivo CSV válido.'));
        }
    }

    return $this->redirect(['action' => 'index']);
}

}
