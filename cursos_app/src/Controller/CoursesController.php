<?php
namespace App\Controller;

use App\Controller\AppController;

class CoursesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Mensajes de notificación
        $this->loadModel('UsersCourses'); // Cargar el modelo intermedio
        $this->loadModel('Users');
    }

    // Método de autorización
    public function isAuthorized($user)
    {
        // Los administradores tienen acceso a todas las acciones
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }

        // Los usuarios regulares solo pueden ver la lista de cursos y los detalles de un curso
        $allowedActions = ['index', 'view'];
        if (in_array($this->request->getParam('action'), $allowedActions)) {
            return true;
        }

        // Negar acceso por defecto
        return false;
    }

    // Listar todos los cursos
    public function index()
    {
        $searchKeyword = $this->request->getQuery('search'); // Obtener el término de búsqueda desde la URL
        $conditions = [];

        if ($searchKeyword) {
            // Agregar condiciones para la búsqueda de cursos por nombre
            $conditions['Courses.name LIKE'] = '%' . $searchKeyword . '%';
        }

        $this->paginate = [
            'conditions' => $conditions,
            'limit' => 10,
        ];

        $courses = $this->paginate($this->Courses);

        // Si la solicitud es AJAX, renderizar solo el elemento 'courses_table'
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $this->set(compact('courses'));
            return $this->render('/Element/courses_table');
        }

        $this->set(compact('courses', 'searchKeyword'));
    }

    public function view($token = null)
    {
        // Obtener el curso a través del token
        $course = $this->Courses->find('all', [
            'conditions' => ['Courses.token' => $token],
            'contain' => ['Users'],
        ])->firstOrFail();
    
        // Obtener los IDs de los estudiantes ya inscritos en el curso
        $enrolledUserIds = [];
        if (!empty($course->users)) {
            foreach ($course->users as $user) {
                $enrolledUserIds[] = $user->id;
            }
        }
    
        // Obtener los estudiantes no inscritos en el curso
        $conditions = [];
        if (!empty($enrolledUserIds)) {
            $conditions['Users.id NOT IN'] = $enrolledUserIds;
        }
        $notEnrolledStudents = $this->Users->find('all', [
            'conditions' => $conditions,
        ])->all();
    
        $this->set(compact('course', 'notEnrolledStudents'));
    }
    
    
    
    // Agregar un nuevo curso (solo admin)
    public function add()
    {
        $course = $this->Courses->newEntity();
        if ($this->request->is('post')) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('El curso ha sido guardado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El curso no pudo ser guardado. Por favor, intenta de nuevo.'));
        }
        $this->set(compact('course'));
    }

    // Editar un curso existente (solo admin)
    public function edit($token = null)
    {
        // Obtener el curso a través del token
        $course = $this->Courses->find('all', [
            'conditions' => ['Courses.token' => $token],
        ])->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('El curso ha sido actualizado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El curso no pudo ser actualizado. Por favor, intenta de nuevo.'));
        }
        $this->set(compact('course'));
    }

    // Eliminar un curso (solo admin)
    public function delete($token = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        // Obtener el curso a través del token
        $course = $this->Courses->find('all', [
            'conditions' => ['Courses.token' => $token],
        ])->firstOrFail();

        if ($this->Courses->delete($course)) {
            $this->Flash->success(__('El curso ha sido eliminado.'));
        } else {
            $this->Flash->error(__('El curso no pudo ser eliminado. Por favor, intenta de nuevo.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    // Vista de gestión de cursos y estudiantes (solo admin)
    public function manage($token = null)
    {
        // Verificar si el usuario tiene permisos de administrador
        if ($this->request->getSession()->read('Auth.User.role') !== 'admin') {
            $this->Flash->error(__('No tienes permisos para acceder a esta área.'));
            return $this->redirect(['action' => 'index']);
        }
    
        // Obtener el término de búsqueda desde la solicitud
        $searchKeyword = $this->request->getQuery('search');
    
        $conditions = [];
        if ($searchKeyword) {
            $conditions['Courses.name LIKE'] = '%' . $searchKeyword . '%';
        }
    
        // Configurar la paginación de los cursos
        $this->paginate = [
            'conditions' => $conditions,
            'limit' => 10,
        ];
        $courses = $this->paginate($this->Courses);
    
        // Obtener el curso seleccionado, si se ha proporcionado un token de curso
        $selectedCourse = null;
        $studentsEnrolled = [];
    
        if ($token) {
            $selectedCourse = $this->Courses->find('all', [
                'conditions' => ['Courses.token' => $token],
                'contain' => ['Users'],
            ])->firstOrFail();
    
            // Obtener los estudiantes inscritos
            if (!empty($selectedCourse->users)) {
                $studentsEnrolled = $selectedCourse->users;
            }
        }
    
        $this->set(compact('courses', 'selectedCourse', 'studentsEnrolled', 'searchKeyword'));
    
        // Si la solicitud es AJAX, renderizar solo el elemento 'courses_table'
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            return $this->render('/Element/courses_table');
        }
    }
    
    // Acción para inscribir un estudiante al curso
    public function enroll($courseToken, $userId)
    {
        // Obtener el curso
        $course = $this->Courses->find('all', [
            'conditions' => ['Courses.token' => $courseToken]
        ])->firstOrFail();
    
        // Obtener el usuario
        $user = $this->Users->get($userId);
    
        // Asociar el usuario al curso
        $this->Courses->Users->link($course, [$user]);
    
        $this->Flash->success(__('User has been enrolled in the course.'));
        return $this->redirect(['action' => 'view', $courseToken]);
    }
    
    public function unenroll($courseToken, $userId)
    {
        // Obtener el curso
        $course = $this->Courses->find('all', [
            'conditions' => ['Courses.token' => $courseToken],
            'contain' => ['Users']
        ])->firstOrFail();
    
        // Obtener el usuario
        $user = $this->Users->get($userId);
    
        // Desasociar el usuario del curso
        if ($this->Courses->Users->unlink($course, [$user])) {
            $this->Flash->success(__('User has been unenrolled from the course.'));
        } else {
            $this->Flash->error(__('Unable to unenroll the user from the course. Please try again.'));
        }
    
        return $this->redirect(['action' => 'view', $courseToken]);
    }
    

    
    
public function searchEnrolled($token = null)
{
    $searchKeyword = $this->request->getQuery('enrolled_search');

    // Obtener el curso y los usuarios inscritos en el curso
    $course = $this->Courses->find('all', [
        'conditions' => ['Courses.token' => $token],
        'contain' => ['Users'],
    ])->firstOrFail();

    $enrolledStudents = collection($course->users);

    // Filtrar los estudiantes si existe un término de búsqueda
    if ($searchKeyword) {
        $enrolledStudents = $enrolledStudents->filter(function ($user) use ($searchKeyword) {
            return stripos($user->username, $searchKeyword) !== false ||
                   stripos($user->email, $searchKeyword) !== false;
        });
    }

    // Convertir la colección en array para la vista
    $enrolledStudents = $enrolledStudents->toArray();

    // Pasar el curso a la vista para poder acceder al token
    $this->set(compact('enrolledStudents', 'course'));

    // Establecer el layout AJAX para la vista parcial
    $this->viewBuilder()->setLayout('ajax');

    return $this->render('/Element/courses/search_enrolled');
}

public function searchNotEnrolled($token = null)
{
    $searchKeyword = $this->request->getQuery('not_enrolled_search');

    // Obtener el curso y los usuarios inscritos en el curso
    $course = $this->Courses->find('all', [
        'conditions' => ['Courses.token' => $token],
        'contain' => ['Users'],
    ])->firstOrFail();

    // Obtener los IDs de los estudiantes ya inscritos en el curso
    $enrolledUserIds = collection($course->users)->extract('id')->toList();

    // Configurar las condiciones para la búsqueda de los no inscritos
    $conditions = [];
    if (!empty($enrolledUserIds)) {
        $conditions['Users.id NOT IN'] = $enrolledUserIds;
    }
    if ($searchKeyword) {
        $conditions['OR'] = [
            'Users.username LIKE' => '%' . $searchKeyword . '%',
            'Users.email LIKE' => '%' . $searchKeyword . '%',
        ];
    }

    // Obtener los estudiantes no inscritos
    $notEnrolledStudents = $this->Users->find('all', [
        'conditions' => $conditions,
    ])->all();

    // Pasar los datos a la vista y establecer el layout AJAX
    $this->set(compact('notEnrolledStudents', 'course'));
    $this->viewBuilder()->setLayout('ajax');

    return $this->render('/Element/courses/search_not_enrolled');
}





    // Método para buscar cursos (usado para AJAX)
    public function searchCourses()
    {
        $searchKeyword = $this->request->getQuery('search');
        $conditions = [];

        if ($searchKeyword) {
            $conditions['Courses.name LIKE'] = '%' . $searchKeyword . '%';
        }

        $this->paginate = [
            'conditions' => $conditions,
            'limit' => 10,
        ];

        $courses = $this->paginate($this->Courses);

        // Renderizar el elemento que contiene la tabla para la respuesta AJAX
        $this->viewBuilder()->setLayout('ajax');
        $this->set(compact('courses'));
        return $this->render('/Element/course_table');
    }
}
