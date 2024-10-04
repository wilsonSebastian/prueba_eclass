<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Fecha inicio</th>
            <th>Fecha termino</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= h($course->name) ?></td>
                    <td><?= h($course->start_date->format('m/d/y')) ?></td>
                    <td><?= h($course->end_date->format('m/d/y')) ?></td>
                    <td>
                        <?= $this->Html->link('Ver', ['action' => 'view', $course->token]) ?>
                        <?= $this->Html->link('Editar', ['action' => 'edit', $course->token]) ?>
                        <?= $this->Form->postLink('Eliminar', ['action' => 'delete', $course->token], ['confirm' => 'Are you sure?']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4"><?= __('No se encontraron cursos.') ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total')) ?></p>
</div>