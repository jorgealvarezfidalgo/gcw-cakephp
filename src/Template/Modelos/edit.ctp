<?php
$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('Administración de modelos'), [
    'controller' => $this->request->getParam('controller'),
    'action' => 'index'
]);
$this->Breadcrumbs->add('Editar modelo' . ' ' . $entity->id, [
    'controller' => $this->request->getParam('controller'),
    'action' => 'edit',
    $entity->id
]);
$header = [
    'title' => 'Editar modelo'  . ' ' . $entity->id,
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
                <h3>Datos del modelo</h3>
				<?= $this->Form->control(
                    'marca_id',
                    [
                        'label' => 'Marca',
                        'options' => $marcas,
                        'escape' => false
                    ]
                ); ?>
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
