<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;

class CoursesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('courses');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // Definir relaciones si existen
        $this->belongsToMany('Users', [
            'through' => 'UsersCourses',
            'foreignKey' => 'course_id',
            'targetForeignKey' => 'user_id',
        ]);
    }

    public function beforeSave($event, $entity, $options)
    {
        // Si el curso es nuevo y no tiene un token, generarlo automáticamente
        if ($entity->isNew() && empty($entity->token)) {
            $entity->token = Text::uuid();
        }
    }
}
