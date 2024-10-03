<!-- src/Template/Element/courses_list.ctp -->

<div class="courses-section">
    <h3>Tus Cursos Inscritos</h3>
    <div class="course-cards">
        <?php foreach ($enrolledCourses as $course): ?>
            <div class="course-card">
                <h4><?= h($course->name); ?></h4>
                <p><strong>Fecha de inicio:</strong> <?= h($course->start_date); ?></p>
                <p><strong>Fecha de finalización:</strong> <?= h($course->end_date); ?></p>
                <p><strong>Descripción:</strong> <?= h($course->description); ?></p>
                <?= $this->Html->link('Ver Compañeros de Curso', 'javascript:void(0);', [
                    'class' => 'btn show-coursemates',
                    'data-course-id' => $course->id
                ]); ?>
                <div class="coursemates-list" id="coursemates-<?= $course->id ?>" style="display:none;">
                    <h4>Compañeros de Curso:</h4>
                    <ul>
                        <?php foreach ($course->users as $mate): ?>
                            <?php if ($mate->id !== $user['id']): ?>
                                <li><?= h($mate->username); ?> - <?= h($mate->email); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
