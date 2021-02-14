<?php
use Cake\Utility\Inflector;
use Cake\Core\Configure;

$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('Administración de vehículos'), [
    'controller' => 'Vehiculos',
    'action' => 'admin'
]);
$this->Breadcrumbs->add(ucfirst('Contactos del vehículo ' . $id . ' (' . $marca->nombre . ' ' . $modelo->nombre . ')'), [
    'action' => 'index_vehiculo',
	$id
]);

$header = [
    'title' => ucfirst('Contactos del vehículo ' . $id . ' (' . $marca->nombre . ' ' . $modelo->nombre . ')'),
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
        if (!empty($entities->toArray())) {
    ?>
        <div class="top-results">
            <div class="num-results">
                <?= $this->element('paginator'); ?>
                <?= $this->Paginator->counter('<span>Mostrando {{start}}-{{end}} de {{count}} elementos</span>'); ?>
            </div><!-- .num-results -->
        </div><!-- .top-results -->
        <table>
            <thead>
                <tr>
					<th>
                        Usuario (email)
                    </th>
					<th>
                        Mensaje
                    </th>
                <?php
                    if (!empty($table_buttons)) {
                ?>
                    <th class="actions short">
                        Operaciones
                    </th>
                <?php
                    }
                ?>
                </tr>
            </thead>
            <tbody>
        <?php
            foreach ($entities as $entity) {
        ?>
                <tr>
					<td class="element">
                        <p><?= $usuarios[$entity->usuario_id]; ?></p>
                    </td>
					<td class="element">
                        <p><?= $entity->mensaje; ?></p>
                    </td>
                    <?php
                        if (!empty($table_buttons)) {
                    ?>
                        <td class="actions">
                        <?php
                            foreach ($table_buttons as $key => $value) {
                                array_push($value['url'], $entity->id);
                                if ($value['url']['action'] != 'delete') {
                                    echo $this->Html->link(
                                        $key,
                                        $value['url'],
                                        $value['options']
                                    );
                                } else {
                                    echo $this->Form->postLink(
                                        $key,
                                        $value['url'],
                                        $value['options']
                                    );
                                }
                            }
                        ?>
                        </td>
                    <?php
                        }
                    ?>
                </tr>
        <?php
            }
        ?>
            </tbody>
        </table>
        <?= $this->element('paginator'); ?>
    <?php
        } else {
    ?>
        <p class="no-results">No existen resultados para la búsqueda realizada</p>
    <?php
        }
    ?>
    </div><!-- .results -->
</div><!-- .content -->
