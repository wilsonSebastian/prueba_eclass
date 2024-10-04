<?= $this->Html->css('editC') ?>
<div class="edit-course-container">
    <!-- Header -->
    <div class="edit-course-header">Editar curso</div>

    <!-- Edit Course Form -->
    <?= $this->Form->create($course) ?>
    <div class="form-group">
        <?= $this->Form->label('name', 'Nombre') ?>
        <?= $this->Form->control('name', ['label' => false, 'class' => 'input']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label('description', 'Descripción') ?>
        <?= $this->Form->control('description', ['label' => false, 'type' => 'textarea', 'class' => 'textarea']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label('start_date', 'Fecha inicio') ?>
        <?= $this->Form->control('start_date', ['label' => false, 'type' => 'date', 'class' => 'input']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label('end_date', 'Fecha termino') ?>
        <?= $this->Form->control('end_date', ['label' => false, 'type' => 'date', 'class' => 'input']) ?>
    </div>

    <!-- Buttons -->
    <div class="button-container">
        <?= $this->Form->button('Actualizar', ['class' => 'button update-button']) ?>
        <?= $this->Html->link('Volver', ['action' => 'index'], ['class' => 'button back-button']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>