<?php
$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('Administración de combustibles'), [
    'controller' => $this->request->getParam('controller'),
    'action' => 'index'
]);
$this->Breadcrumbs->add('Añadir combustible', [
    'controller' => $this->request->getParam('controller'),
    'action' => 'add'
]);
$header = [
    'title' => 'Añadir combustible',
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
                <h3>Datos del combustible</h3>
                <?= $this->Form->control(
                    'nombre',
                    [
                        'label' => 'Nombre',
                        'type' => 'text'
                    ]
                ); ?>
            </div>     
    </div><!-- .primary -->
    <?= $this->element("form/save-block"); ?>
<?= $this->Form->end(); ?>
</div><!-- .content -->
