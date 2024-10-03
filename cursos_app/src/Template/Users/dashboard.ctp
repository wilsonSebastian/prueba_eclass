<?= $this->Html->css('dashboard') ?>
<!-- src/Template/Users/dashboard.ctp -->
<div class="dashboard-container">
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar-btn" id="toggleSidebar">
            &lt;&gt;
        </button>
        

        <div class="menu">
            <ul>
                <?php if ($user['role'] === 'admin'): ?>
                    <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">Ver todos los usuarios</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Courses', 'action' => 'index']); ?>">Ver todos los cursos</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="logout-button">
           Cerrar sesión
        </a>
    </div>

    <div class="main-content" id="mainContent">
        <h1>Bienvenido, <?= h($user['username']); ?></h1>

        <?php if ($user['role'] === 'admin'): ?>
            <div class="admin-section">
                <h2>Panel de Administración</h2>
                <div class="admin-options">
                    <h3>Gestionar Usuarios</h3>
                    <p><?= $this->Html->link('Ver todos los usuarios', ['controller' => 'Users', 'action' => 'index']); ?></p>
                    <h3>Gestionar Cursos</h3>
                    <p><?= $this->Html->link('Ver todos los cursos', ['controller' => 'Courses', 'action' => 'index']); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="user-section">
                <p>Aquí encontrarás tus cursos e información relevante.</p>
                <!-- Formulario para buscar cursos por nombre -->
                <div class="course-filter-form">
                    <?= $this->Form->create(null, ['type' => 'get', 'id' => 'courseSearchForm']) ?>
                    <fieldset>
                        <legend>Buscar Cursos por Nombre</legend>
                        <?= $this->Form->control('course_name', ['type' => 'text', 'label' => 'Nombre del Curso', 'required' => false, 'placeholder' => 'Ingrese el nombre del curso']) ?>
                        <?= $this->Form->button('Buscar Cursos', ['type' => 'submit']) ?>
                    </fieldset>
                    <?= $this->Form->end() ?>
                </div>

                <!-- Mostrar los cursos inscritos en forma de tarjetas -->
                <?php if (!empty($enrolledCourses)): ?>
                    <div class="courses-section">
                        <h3>Tus Cursos Inscritos</h3>
                        <div class="course-cards">
                            <?php foreach ($enrolledCourses as $course): ?>
                                <?php if (!empty($course)): ?>
                                    <div class="course-card">
                                        <h4><?= h($course->name); ?></h4>
                                        <p><strong>Fecha de inicio:</strong> <?= h($course->start_date); ?></p>
                                        <p><strong>Fecha de finalización:</strong> <?= h($course->end_date); ?></p>
                                        <p><strong>Descripción:</strong> <?= h($course->description); ?></p>
                                        <?= $this->Html->link('Ver Compañeros de Curso', 'javascript:void(0);', [
                                            'class' => 'show-coursemates btn',
                                            'data-course-id' => $course->id
                                        ]); ?>
                                        <div class="coursemates-list" id="coursemates-<?= $course->id ?>" style="display:none;">
                                            <h4>Compañeros de Curso:</h4>
                                            <?php if (!empty($course->users)): ?>
                                                <ul>
                                                    <?php foreach ($course->users as $mate): ?>
                                                        <?php if ($mate->id !== $user['id']): ?>
                                                            <li><?= h($mate->username); ?> - <?= h($mate->email); ?></li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p>No hay otros compañeros inscritos en este curso.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No estás inscrito en ningún curso con ese nombre.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->Html->script('dashboardU') ?>
