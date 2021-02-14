<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'TRUBIAUTOS';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('miw.css') ?>

    <?php
    // JQUERY
    $this->Html->css('vendors/jquery-ui-1.12.1/jquery-ui.min', ['block' => 'vendors']);
    $this->Html->script('vendors/jquery/jquery-3.3.1.min', ['block' => 'vendors']);
    $this->Html->script('vendors/jquery/jquery-ui-1.12.1/jquery-ui.min', ['block' => 'vendors']);

    // SELECT 2
    $this->Html->css('vendors/select2/select2.min', ['block' => 'vendors']);
    $this->Html->script('vendors/select2/select2.full.min', ['block' => 'vendors']);
    $this->Html->script('vendors/select2/select2_locale_es', ['block' => 'vendors']);

    // TINYMCE
    $this->Html->script("//cdn.tinymce.com/4/tinymce.min.js", ['block' => "vendors"]);
    $this->Html->script('vendors/tinymce/es', ['block' => 'vendors']);

        // FUNCTIONS
        $this->Html->script('functions', ['block' => 'scripts']);

    echo $this->fetch('css');
    echo $this->fetch('vendors');
    echo $this->fetch('scripts');

    ?>
</head>
<body>

    <?= $this->Flash->render() ?>
    <div class="container clearfix full" id="main-content">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
	<ul>
	<li>Jorge Álvarez Fidalgo - 2021</li>
	<li>Máster Universitario en Ingeniería Web</li>
	<li>Universidad de Oviedo</li>
	</ul>
	</footer>
</body>
</html>
