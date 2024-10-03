<?= $this->Html->css('addU') ?>
<div class="card-container">
    <h1>Agregar usuario</h1>

    <?= $this->Form->create($user) ?>
        <div class="form-control">
            <?= $this->Form->control('nombre', ['label' => 'Nombre']) ?>
        </div>
        <div class="form-control">
            <?= $this->Form->control('email', ['label' => 'Email']) ?>
        </div>
        <div class="form-control">
            <?= $this->Form->control('contraseña', ['label' => 'Contraseña']) ?>
        </div>
        <div class="form-control">
            <?= $this->Form->control('rol', ['type' => 'select', 'options' => ['user' => 'User', 'admin' => 'Admin'], 'label' => 'Rol']) ?>
        </div>
        <div class="form-control">
            <?= $this->Form->control('Estado', ['type' => 'select', 'options' => ['active' => 'Active', 'inactive' => 'Inactive'], 'label' => 'Estado']) ?>
        </div>
        <div class="form-buttons">
            <?= $this->Form->button('Registrar usuario', ['class' => 'button register-button']) ?>
            <?= $this->Html->link('Volver', ['action' => 'index'], ['class' => 'button back-button']) ?>
        </div>
    <?= $this->Form->end() ?>
</div>
