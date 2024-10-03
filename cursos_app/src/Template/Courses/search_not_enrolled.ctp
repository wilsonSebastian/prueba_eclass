<?php if (!empty($notEnrolledStudents)): ?>
    <ul>
        <?php foreach ($notEnrolledStudents as $student): ?>
            <li>
                <?= h($student->username) ?> (<?= h($student->email) ?>)
                <?php if (!empty($course->token)): ?>
                    <?= $this->Html->link('Enroll', ['controller' => 'Courses', 'action' => 'enroll', $course->token, $student->id], ['class' => 'button']) ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>All users are enrolled in this course.</p>
<?php endif; ?>
