<!-- src/Template/Users/index.ctp -->
<?= $this->Html->css('dashboard') ?>
<?= $this->Html->css('indexU') ?>

<div class="dashboard-container">
    <!-- Sidebar del dashboard -->
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar-btn" id="toggleSidebar">
            &#60;&#62;
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

    <div class="main-content">
        <!-- Contenedor para agrupar el Buscador, Add User y Carga Masiva -->
        <div class="user-actions-container">
            <!-- Formulario de Búsqueda Automática -->
            <div class="search-form">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'id' => 'searchForm']) ?>
                <fieldset>
                    <legend>Buscar usuario</legend>
                    <?= $this->Form->control('search', [
                        'label' => false,
                        'placeholder' => 'Buscar por nombre de usuario',
                        'value' => $searchKeyword,
                        'class' => 'search-input',
                        'id' => 'searchInput',
                    ]) ?>
                </fieldset>
                <?= $this->Form->end() ?>
            </div>

            <!-- Botón de Agregar Usuario -->
            <div class="add-user-section">
                <p><?= $this->Html->link('Registrar usuario', ['action' => 'add'], ['class' => 'button add-user-button']) ?></p>
            </div>

            <!-- Formulario de Carga Masiva de Usuarios -->
            <div class="bulk-upload-form">
                <h3>Realizar carga masiva</h3>
                <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'Users', 'action' => 'bulkUpload'], 'class' => 'form-inline']) ?>
                <?= $this->Form->control('file', [
                    'type' => 'file',
                    'label' => false,
                    'class' => 'bulk-upload-input'
                ]) ?>
                <?= $this->Form->button('Cargar Usuarios', ['class' => 'button bulk-upload-button']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div id="userTable">
            <!-- Tabla de Usuarios -->
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= h($user->username) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->role) ?></td>
                            <td><?= h($user->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('Ver', ['action' => 'view', $user->token]) ?>
                                <?= $this->Html->link('Editar', ['action' => 'edit', $user->token]) ?>
                                <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $user->token], ['confirm' => '¿Estás seguro?']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('First')) ?>
                    <?= $this->Paginator->prev('< ' . __('Previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('Next') . ' >') ?>
                    <?= $this->Paginator->last(__('Last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total')) ?></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', function() {
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

        // JavaScript para realizar búsqueda asíncrona (AJAX) de usuarios
        let debounceTimer;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                // Obtener el valor de búsqueda
                const searchValue = document.getElementById('searchInput').value;

                // Realizar la petición AJAX
                fetch(`<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>?search=${searchValue}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Actualizar la tabla de usuarios con la respuesta obtenida
                        document.getElementById('userTable').innerHTML = html;
                    })
                    .catch(error => console.error('Error:', error));
            }, 500); // Esperar 500ms después de que el usuario deja de escribir
        });
    });
</script>