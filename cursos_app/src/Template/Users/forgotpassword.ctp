<?= $this->Html->css('forgotpassword') ?>

<div class="login-container">
    <div class="card">
        <h1>Recuperar Contraseña</h1>
        <p>Por favor, ingrese su dirección de correo electrónico para enviarle un enlace de restablecimiento de contraseña.</p>
        
        <div id="notification" class="notification" style="display: none;">
            No hay servidor de correos configurado para poder hacer funcionar este apartado, pero la lógica de funcionamiento se encuentra completa en el controlador correspondiente.
        </div>

        <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'forgotpassword'], 'id' => 'resetPasswordForm']) ?>
        <fieldset>
            <legend>Correo Electrónico</legend>
            <?= $this->Form->control('email', [
                'label' => false,
                'placeholder' => 'Ingrese su correo electrónico',
                'required' => true,
                'type' => 'email'
            ]) ?>
        </fieldset>
        <?= $this->Form->button(__('Enviar Enlace de Restablecimiento'), ['class' => 'btn-reset']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<?= $this->Html->script('forgotpassword') ?>
