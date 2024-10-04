<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Utility\Security;
use Cake\ORM\Entity;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Configurar la tabla de la base de datos asociada a este modelo
        $this->setTable('users');
        $this->setPrimaryKey('id');
        $this->setDisplayField('username'); // Campo que se mostrará por defecto (opcional)

        // Comportamiento para timestamps automáticos
        $this->addBehavior('Timestamp');

        // Relación 1 a muchos con UsersCourses
        $this->hasMany('UsersCourses', [
            'foreignKey' => 'user_id',
        ]);

        // Relación muchos a muchos con Courses, a través de UsersCourses
        $this->belongsToMany('Courses', [
            'through' => 'UsersCourses',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'course_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('username', 'El nombre de usuario es obligatorio')
            ->minLength('username', 3, 'El nombre de usuario debe tener al menos 3 caracteres.')
            ->maxLength('username', 50, 'El nombre de usuario no puede tener más de 50 caracteres.')

            ->notEmptyString('password', 'La contraseña es obligatoria')
            ->minLength('password', 6, 'La contraseña debe tener al menos 6 caracteres.')

            ->notEmptyString('email', 'El correo electrónico es obligatorio')
            ->email('email', false, 'Debe proporcionar un correo electrónico válido')

            ->inList('role', ['user', 'admin'], 'Por favor, selecciona un rol válido.')
            ->notEmptyString('status', 'El estado del usuario es obligatorio')
            ->inList('status', ['active', 'inactive'], 'Por favor, selecciona un estado válido.');

        return $validator;
    }

    public function beforeSave(Event $event, Entity $entity, $options)
    {
        // Verificar si el usuario es nuevo o si la contraseña fue modificada
        if ($entity->isNew() || $entity->isDirty('password')) {
            if (!empty($entity->password)) {
                // Hashear la contraseña antes de guardarla
                $entity->password = (new DefaultPasswordHasher())->hash($entity->password);
            }
        }

        // Generar un token único si es un nuevo usuario
        if ($entity->isNew() && empty($entity->token)) {
            $entity->token = Security::hash($entity->username . time(), 'sha256', true);
        }
    }
}
