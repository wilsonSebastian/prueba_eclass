<h1>Inscribir Usuario en Curso</h1>

<?= $this->Form->create() ?>
<fieldset>
    <legend><?= __('Selecciona un usuario y un curso para la inscripción') ?></legend>
    <?= $this->Form->control('user_id', ['type' => 'select', 'options' => $users, 'label' => 'Usuario']); ?>
    <?= $this->Form->control('course_id', ['type' => 'select', 'options' => $courses, 'label' => 'Curso']); ?>
</fieldset>
<?= $this->Form->button(__('Inscribir')) ?>
<?= $this->Form->end() ?>

<p><?= $this->Html->link('Volver al Dashboard', ['action' => 'dashboard']) ?></p>
