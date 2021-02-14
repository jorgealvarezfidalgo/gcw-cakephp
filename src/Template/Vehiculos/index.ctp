<?php
use Cake\Utility\Inflector;
use Cake\Core\Configure;

$this->Breadcrumbs->add('Inicio', '/');
$this->Breadcrumbs->add(ucfirst('Catálogo de vehículos'), [
    'controller' => $this->request->getParam('controller'),
    'action' => 'index'
]);
$header = [
    'title' => ucfirst('Catálogo de vehículos'),
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
                        Marca
                    </th>
                    <th>
                        Modelo
                    </th>
					<th>
                        Combustible
                    </th>
					<th>
                        Precio
                    </th>
					<th>
                        Año
                    </th>
					<th>
                        Kilómetros
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
                        <p><?= $marcas[$marcas_modelos[$entity->modelo_id]]; ?></p>
                    </td>
                    <td class="element">
                        <p><?= $modelos[$entity->modelo_id]; ?></p>
                    </td>
					<td class="element">
                        <p><?= $combustibles[$entity->combustible_id]; ?></p>
                    </td>
					<td class="element">
                        <p><?= $entity->precio; ?> €</p>
                    </td>
					<td class="element">
                        <p><?= $entity->anno; ?></p>
                    </td>
					<td class="element">
                        <p><?= $entity->kms; ?></p>
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
