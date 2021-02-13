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
        <table>
            <thead>
                <tr>
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
                <tr>
                    <td class="element">
                        <p><?= $entity->modelo_id; ?></p>
                    </td>
					<td class="element">
                        <p><?= $entity->combustible_id; ?></p>
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
            </tbody>
        </table>
    <?php
        } else {
    ?>
        <p class="no-results">No existen resultados para la búsqueda realizada</p>
    <?php
        }
    ?>
    </div><!-- .results -->
</div><!-- .content -->
