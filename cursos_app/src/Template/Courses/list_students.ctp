<h1>Listado de Cursos y Estudiantes Inscritos</h1>

<?php foreach ($courses as $course): ?>
    <div class="course">
        <h2>Curso: <?= h($course->name) ?></h2>
        <?php if (!empty($course->users)): ?>
            <ul>
                <?php foreach ($course->users as $user): ?>
                    <li>
                        <?= h($user->username) ?>
                        (<?= $this->Html->link('Eliminar', ['action' => 'removeStudent', $course->id, $user->id]) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay estudiantes inscritos en este curso.</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<p><?= $this->Html->link('Volver al Dashboard', ['controller' => 'Users', 'action' => 'dashboard']) ?></p>