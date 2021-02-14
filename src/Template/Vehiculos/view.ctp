<?php
use Cake\Utility\Inflector;
use Cake\Core\Configure;

$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('Catálogo de vehículos'), [
    'controller' => $this->request->getParam('controller'),
    'action' => 'index'
]);
$this->Breadcrumbs->add('Detalle de ' . ' ' . $marca->nombre . ' ' . $modelo->nombre, [
    'controller' => $this->request->getParam('controller'),
    'action' => 'view',
    $entity->id
]);
$header = [
    'breadcrumbs' => true,
    'header' => [
        'actions' => $header_actions
    ]
];
?>

<?= $this->element("header", $header); ?>

<div class="content">
    <div class="results">
    <?php
        if ($entity) {
    ?>
		<h1><?= $marca->nombre; ?> <?= $modelo->nombre ?></h1>
		<h2><?= $entity->precio; ?> €</h2>
		<?= $this->Html->image('coche_estandar.jpg') ?>
		<section id="detalles">
			<p><strong>Combustible:</strong> <?= $combustible->nombre; ?></p>
			<p><strong>Año:</strong> <?= $entity->anno; ?></p>
			<p><strong>Kilómetros:</strong> <?= $entity->kms; ?></p>
		</section>
    <?php
        } else {
    ?>
        <p class="no-results">No existen resultados para la búsqueda realizada</p>
    <?php
        }
    ?>
    </div><!-- .results -->
</div><!-- .content -->
