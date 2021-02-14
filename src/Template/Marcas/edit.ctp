<?php
$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('Administración de marcas'), [
    'controller' => $this->request->getParam('controller'),
    'action' => 'index'
]);
$this->Breadcrumbs->add('Editar marca' . ' ' . $entity->id, [
    'controller' => $this->request->getParam('controller'),
    'action' => 'edit',
    $entity->id
]);
$header = [
    'title' => 'Editar marca'. ' ' . $entity->id,
    'breadcrumbs' => true
];
?>

<?= $this->element("header", $header); ?>

<div class="content">
<?= $this->Form->create(
    $entity,
    [
        'class' => 'admin-form',
        'type' => 'file'
    ]
); ?>
    <div class="primary">
            <div class="form-block">
                <h3>Datos de la marca</h3>
                <?= $this->Form->control(
                    'nombre',
                    [
                        'label' => 'Nombre',
                        'type' => 'text'
                    ]
                ); ?>
            </div><!-- .form-block -->
    </div><!-- .primary -->
    <?= $this->element("form/save-block"); ?>
<?= $this->Form->end() ?>
</div><!-- .content -->
