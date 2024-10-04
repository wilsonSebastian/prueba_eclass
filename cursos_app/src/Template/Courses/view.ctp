<?= $this->Html->css('viewC') ?>

<div class="course-details-container">
    <!-- Course Details Section -->
    <div class="course-card">
        <div class="course-header">Detalles del curso</div>
        <div class="course-info">
            <p><strong>Nombre:</strong> <?= h($course->name); ?></p>
            <p><strong>Descripción:</strong> <?= h($course->description); ?></p>
            <p><strong>Fecha inicio:</strong> <?= h($course->start_date); ?></p>
            <p><strong>Fecha termino:</strong> <?= h($course->end_date); ?></p>
        </div>
    </div>

    <!-- Enrolled Students Section -->
    <div class="students-section">
        <!-- Enrolled Students -->
        <div class="students-list">
            <div class="students-header">Estudiantes inscritos</div>
            <div class="student-list">
                <?php if (!empty($course->users)): ?>
                    <?php foreach ($course->users as $user): ?>
                        <div class="student-item">
                            <div class="student-info"><?= h($user->username); ?> (<?= h($user->email); ?>)</div>
                            <?= $this->Html->link('Eliminar', ['controller' => 'Courses', 'action' => 'unenroll', $course->token, $user->id], ['class' => 'student-button', 'confirm' => 'Are you sure you want to unenroll this student?']) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="student-info">El curso no cuenta con estudiantes inscritos.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Not Enrolled Students -->
        <div class="students-list">
            <div class="students-header">Estudiantes no inscritos</div>
            <div class="student-list">
                <?php if (!empty($notEnrolledStudents)): ?>
                    <?php foreach ($notEnrolledStudents as $student): ?>
                        <div class="student-item">
                            <div class="student-info"><?= h($student->username); ?> (<?= h($student->email); ?>)</div>
                            <?= $this->Html->link('Matricular', ['controller' => 'Courses', 'action' => 'enroll', $course->token, $student->id], ['class' => 'student-button']) ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="student-info">No hay estudiantes por inscribir</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Edit and Back Buttons -->
    <div class="button-container">
        <?= $this->Html->link('Volver al dashboard', ['controller' => 'Users', 'action' => 'dashboard'], ['class' => 'button']) ?>
    </div>
</div>