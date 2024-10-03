<?= $this->Html->css('addC') ?>
<div class="add-course-container">
    <!-- Header -->
    <div class="add-course-header">Registrar nuevo curso</div>

    <!-- Add Course Form -->
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
        <?= $this->Form->button('Crear curso', ['class' => 'button save-button']) ?>
        <?= $this->Html->link('Volver', ['action' => 'index'], ['class' => 'button back-button']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
