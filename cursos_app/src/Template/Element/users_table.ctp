<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->role) ?></td>
                <td><?= h($user->status) ?></td>
                <td>
                    <?= $this->Html->link('View', ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $user->id], ['confirm' => 'Are you sure?']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
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