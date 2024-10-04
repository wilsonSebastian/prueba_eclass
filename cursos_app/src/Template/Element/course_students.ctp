<h3>Curso Seleccionado: <?= h($selectedCourse->name) ?></h3>

<h4>Estudiantes Inscritos</h4>
<ul>
    <?php foreach ($selectedCourse->users as $student): ?>
        <li>
            <?= h($student->username) ?> -
            <?= $this->Html->link('Eliminar del Curso', ['action' => 'removeStudent', $selectedCourse->id, $student->id], ['confirm' => '¿Estás seguro de que deseas eliminar a este estudiante?']) ?>
        </li>
    <?php endforeach; ?>
</ul>

<h4>Inscribir Nuevo Estudiante</h4>
<ul>
    <?php foreach ($studentsNotEnrolled as $student): ?>
        <li>
            <?= h($student->username) ?> -
            <?= $this->Html->link('Inscribir', ['action' => 'enrollStudent', $selectedCourse->id, $student->id]) ?>
        </li>
    <?php endforeach; ?>
</ul>