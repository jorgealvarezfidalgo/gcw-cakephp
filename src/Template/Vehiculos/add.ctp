<?php
$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('vehiculos'), [
    'controller' => $this->request->getParam('controller'),
    'action' => 'index'
]);
$this->Breadcrumbs->add('Añadir vehículo', [
    'controller' => $this->request->getParam('controller'),
    'action' => 'add'
]);
$header = [
    'title' => 'Añadir vehículo',
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
                <h3>Datos del vehículo</h3>
                <?= $this->Form->control(
                    'modelo_id',
                    [
                        'label' => 'Modelo',
                        'options' => $modelos,
                        'escape' => false
                    ]
                ); ?>
				<?= $this->Form->control(
                    'combustible_id',
                    [
                        'label' => 'Combustible',
                        'options' => $combustibles,
                        'escape' => false
                    ]
                ); ?>
                <?= $this->Form->control(
                    'precio',
                    [
                        'label' => 'Precio',
                        'type' => 'number',
                        'min' => 100
                    ]
                ); ?>
                <?= $this->Form->control(
                    'anno',
                    [
                        'label' => 'Año',
                        'type' => 'number',
						'min' => 1900,
						'max' => 2021
                    ]
                ); ?>
				<?= $this->Form->control(
                    'kms',
                    [
                        'label' => 'Kilómetros',
                        'type' => 'number',
                        'min' => 0
                    ]
                ); ?>
            </div>     
    </div><!-- .primary -->
    <?= $this->element("form/save-block"); ?>
<?= $this->Form->end(); ?>
</div><!-- .content -->
