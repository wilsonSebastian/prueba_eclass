<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UsersCoursesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users_courses');
        $this->setPrimaryKey(['user_id', 'course_id']);

        // Relación hacia Usuarios
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        // Relación hacia Cursos
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id'
        ]);
    }
}
