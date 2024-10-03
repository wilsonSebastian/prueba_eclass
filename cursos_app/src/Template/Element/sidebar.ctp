<div class="dashboard-container">
    <div class="sidebar" id="sidebar">
        <button class="toggle-sidebar-btn" id="toggleSidebar">
            &lt;&gt;
        </button>
        

        <div class="menu">
            <ul>
                <?php if ($user['role'] === 'admin'): ?>
                    <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">Gestión de usuarios</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'Courses', 'action' => 'index']); ?>">Gestión de cursos</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="logout-button">
           Cerrar sesión
        </a>
    </div>
