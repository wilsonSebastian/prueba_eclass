<?php if (!empty($enrolledStudents)): ?>
    <ul>
        <?php foreach ($enrolledStudents as $user): ?>
            <li>
                <?= h($user->username) ?> (<?= h($user->email) ?>)
                <?= $this->Html->link('Unenroll', ['controller' => 'Courses', 'action' => 'unenroll', $course->token, $user->id], ['class' => 'button', 'confirm' => 'Are you sure you want to unenroll this student?']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No students are enrolled in this course.</p>
<?php endif; ?>