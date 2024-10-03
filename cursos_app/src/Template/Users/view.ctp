<?= $this->Html->css('view') ?>
<h1>Detalles</h1>

<div class="user-details-container">
    <div class="user-info">
        <p><strong>Nombre de usuario:</strong> <?= h($user->username) ?></p>
        <p><strong>Email:</strong> <?= h($user->email) ?></p>
        <p><strong>Rol:</strong> <?= h($user->role) ?></p>
        <p><strong>Estado:</strong> <?= h($user->status) ?></p>
    </div>

    <div class="buttons-container">
        <p><?= $this->Html->link('Editar', ['action' => 'edit', $user->token], ['class' => 'button edit-button']) ?></p>
        <p><?= $this->Html->link('Volver', ['action' => 'index'], ['class' => 'button back-button']) ?></p>
    </div>
</div>


