<div class="reset-password-container">
    <h2>Restablecer Contraseña</h2>
    <p>Por favor, introduzca su nueva contraseña.</p>

    <?= $this->Form->create() ?>
    <fieldset>
        <?= $this->Form->control('password', [
            'label' => 'Nueva Contraseña',
            'required' => true,
            'type' => 'password',
            'placeholder' => 'Ingrese su nueva contraseña',
            'class' => 'reset-password-input'
        ]) ?>
        <?= $this->Form->control('password_confirm', [
            'label' => 'Confirmar Contraseña',
            'required' => true,
            'type' => 'password',
            'placeholder' => 'Confirme su nueva contraseña',
            'class' => 'reset-password-input'
        ]) ?>
    </fieldset>
    <?= $this->Form->button('Restablecer Contraseña', ['class' => 'btn']) ?>
    <?= $this->Form->end() ?>
</div>