<?php
use Cake\Utility\Inflector;
use Cake\Core\Configure;

$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('vehiculos'), [
    'controller' => $this->request->getParam('controller'),
    'action' => 'index'
]);
$header = [
    'title' => ucfirst('Detalle de vehículo'),
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
