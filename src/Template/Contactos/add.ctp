<?php
$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('Catálogo de vehículos'), [
    'controller' => 'Vehiculos',
    'action' => 'index'
]);
$this->Breadcrumbs->add('Detalle de ' . ' ' . $marca->nombre . ' ' . $modelo->nombre, [
    'controller' => 'Vehiculos',
    'action' => 'view',
    $vehiculo->id
]);
$this->Breadcrumbs->add('Contacto', [
    'controller' => $this->request->getParam('controller'),
    'action' => 'add',
	$vehiculo->id
]);
$header = [
    'title' => 'Contacto',
    'breadcrumbs' => true
];
?>

<?= $this->element("header", $header); ?>

<div class="content">
<?php
        if ($vehiculo) {
    ?>
<?= $this->Form->create(
    $entity,
    [
        'class' => 'admin-form',
        'type' => 'file'
    ]
); ?>
    <div class="primary">
            <div class="form-block">
                <h3>Contactar sobre <?= $marca->nombre; ?> <?= $modelo->nombre; ?></h3>
                <?= $this->Form->control(
                    'nombre',
                    [
                        'label' => 'Nombre',
                        'type' => 'text'
                    ]
                ); ?>
				<?= $this->Form->control(
                    'apellidos',
                    [
                        'label' => 'Apellidos',
                        'type' => 'text'
                    ]
                ); ?>
                <?= $this->Form->control(
                    'email',
                    [
                        'label' => 'Email',
                        'type' => 'email'
                    ]
                ); ?>
                <?= $this->Form->control(
                    'mensaje',
                    [
                        'label' => 'Mensaje',
                        'type' => 'textarea'
                    ]
                ); ?>
            </div>     
    </div><!-- .primary -->
    <?= $this->element("form/save-block"); ?>
<?= $this->Form->end(); ?>
    <?php
        } else {
    ?>
        <p class="no-results">No existe tal vehículo. Por favor, revise la ruta.</p>
    <?php
        }
    ?>
</div><!-- .content -->
