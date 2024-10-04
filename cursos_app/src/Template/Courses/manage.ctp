<h1>Gestión de Cursos y Estudiantes Inscritos</h1>

<!-- Formulario de Búsqueda Automática -->
<div class="search-form">
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'id' => 'searchCourseForm']) ?>
    <?= $this->Form->control('search', [
        'label' => false,
        'placeholder' => 'Buscar curso por nombre',
        'value' => $searchKeyword,
        'class' => 'search-input',
        'id' => 'searchCourseInput',
    ]) ?>
    <?= $this->Form->end() ?>
</div>

<h2>Lista de Cursos</h2>
<div id="courseTableContainer">
    <!-- Incluir el elemento que contiene la tabla de cursos -->
    <?= $this->element('courses_table', ['courses' => $courses]) ?>
</div>

<?php if ($selectedCourse): ?>
    <h2>Gestionar Estudiantes de <?= h($selectedCourse->name) ?></h2>

    <div class="students-section">
        <h3>Estudiantes Inscritos</h3>
        <?php if (!empty($studentsEnrolled)): ?>
            <ul>
                <?php foreach ($studentsEnrolled as $student): ?>
                    <li><?= h($student->username) ?> - <?= h($student->email) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay estudiantes inscritos en este curso.</p>
        <?php endif; ?>

        <h3>Estudiantes No Inscritos</h3>
        <?php if (!empty($studentsNotEnrolled)): ?>
            <ul>
                <?php foreach ($studentsNotEnrolled as $student): ?>
                    <li><?= h($student->username) ?> - <?= h($student->email) ?>
                        <?= $this->Form->postLink('Inscribir', ['action' => 'enrollStudent', $selectedCourse->id, $student->id], ['confirm' => '¿Estás seguro de que deseas inscribir a este estudiante?']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay estudiantes disponibles para inscribir en este curso.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<script>
    // JavaScript para realizar búsqueda asíncrona (AJAX) de cursos
    let debounceTimer;
    document.getElementById('searchCourseInput').addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() {
            // Obtener el valor de búsqueda
            const searchValue = document.getElementById('searchCourseInput').value;

            // Realizar la petición AJAX
            fetch(`<?= $this->Url->build(['controller' => 'Courses', 'action' => 'manage']) ?>?search=${searchValue}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Actualizar el contenedor de la tabla de cursos con la respuesta obtenida
                    document.getElementById('courseTableContainer').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }, 500); // Esperar 500ms después de que el usuario deja de escribir
    });
</script>