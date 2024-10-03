<!-- src/Template/Users/login.ctp -->

<?= $this->Html->css('login') ?>

<div class="login-container">
    <div class="login-box">
        <h1>eClass - Iniciar Sesión</h1>
        <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'login']]) ?>
        <fieldset>
            <legend><?= __('Iniciar sesión') ?></legend>
            <?= $this->Form->control('username', ['label' => false, 'placeholder' => 'Correo electrónico, teléfono o nombre de usuario']) ?>
            <?= $this->Form->control('password', ['type' => 'password', 'label' => false, 'placeholder' => 'Contraseña']) ?>
        </fieldset>
        <?= $this->Form->button(__('Siguiente'), ['class' => 'btn-login']) ?>
        <?= $this->Form->end() ?>
        <p><?= $this->Html->link("¿No puede acceder a su cuenta?", ['controller' => 'Users', 'action' => 'forgotpassword']) ?></p>
    </div>
</div>
