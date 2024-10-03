<?= $this->Html->css('editU') ?>
<div class="edit-user-card">
    <h1 class="page-title">Editar Usuario</h1>
    <?= $this->Form->create($user, ['class' => 'form-container']) ?>
        <div class="form-group">
            <?= $this->Form->control('username', ['label' => 'Nombre', 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('password', ['label' => 'Contraseña', 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('role', ['label' => 'Rol', 'options' => ['user' => 'User', 'admin' => 'Admin'], 'class' => 'form-control']) ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('status', ['label' => 'Estado', 'options' => ['active' => 'Active', 'inactive' => 'Inactive'], 'class' => 'form-control']) ?>
        </div>
        <div class="button-group">
            <?= $this->Form->button('Actualizar', ['class' => 'button-update button-size']) ?>
            <?= $this->Html->link('Volver', ['action' => 'index'], ['class' => 'button-back button-size']) ?>
        </div>
    <?= $this->Form->end() ?>
</div>
