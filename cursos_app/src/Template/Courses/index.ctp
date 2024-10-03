<?= $this->Html->css('indexC') ?>
<?= $this->Html->css('dashboard') ?>
<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar-btn" id="toggleSidebar">
            &lt;&gt;
        </button>

        <div class="menu">
            <ul>
                <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">Ver todos los usuarios</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Courses', 'action' => 'index']); ?>">Ver todos los cursos</a></li>
            </ul>
        </div>

        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="logout-button">
           Cerrar sesión
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <h1>Buscar curso</h1>

        <!-- Formulario de Búsqueda Automática -->
        <div class="search-form">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'id' => 'searchCourseForm']) ?>
            <?= $this->Form->control('search', [
                'label' => false,
                'placeholder' => 'Buscar por nombre de curso',
                'value' => $searchKeyword,
                'class' => 'search-input',
                'id' => 'searchCourseInput',
            ]) ?>
            <?= $this->Form->end() ?>
        </div>

        <p><?= $this->Html->link('Agregar curso', ['action' => 'add'], ['class' => 'button']) ?></p>

        <div id="courseTable">
            <!-- Tabla de Cursos -->
            <?= $this->element('courses_table', ['courses' => $courses]) ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', function () {
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                sidebar.style.width = '250px';
                toggleBtn.style.left = '250px';
            } else {
                sidebar.classList.add('collapsed');
                sidebar.style.width = '0';
                toggleBtn.style.left = '10px'; // Siempre visible al colapsar
            }
        });

        // JavaScript para realizar búsqueda asíncrona (AJAX) de cursos
        let debounceTimer;
        document.getElementById('searchCourseInput').addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                // Obtener el valor de búsqueda
                const searchValue = document.getElementById('searchCourseInput').value;

                // Construir la URL para la búsqueda
                const url = '<?= $this->Url->build(['controller' => 'Courses', 'action' => 'index']) ?>' + '?search=' + encodeURIComponent(searchValue);

                // Realizar la petición AJAX
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Actualizar la tabla de cursos con la respuesta obtenida
                    document.getElementById('courseTable').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
            }, 500); // Esperar 500ms después de que el usuario deja de escribir
        });
    });
</script>
