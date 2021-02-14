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
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;


?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        TrubiAutos
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body class="home">

<header class="row">
    <div class="header-image"><?= $this->Html->image('cake-logo.png') ?></div>
</header>

<div class="row cabecera">
	<h2>
    <a href="/Vehiculos"><span>Catálogo de vehículos</span></a>
	</h2>
</div>

<div class="row">
<h3>Funciones de administración</h3>
	<hr/>
    <div class="columns large-4">
        <i class="icon bi bi-key-fill"></i>
        <h3>Gestión de vehículos</h3>
        <ul>
            <li class="bullet">
                <a href="/Vehiculos/admin">Administración de vehículos</a>
            </li>
            <li class="bullet">
                <a href="/Marcas">Administración de marcas</a>
            </li>
            <li class="bullet">
                <a href="/Modelos">Administración de modelos</a>
            </li>
             <li class="bullet">
                <a href="/Combustibles">Administración de combustibles</a>
            </li>
        </ul>
    </div>
    <div class="columns large-4">
        <i class="icon bi bi-people-fill"></i>
        <h3>Gestión de usuarios</h3>
        <ul>
            <li class="bullet">
                <a href="/Usuarios">Administración de usuarios</a>
            </li>
        </ul>
    </div>
    <div class="columns large-4">
        <i class="icon bi bi-envelope-fill"></i>
        <h3>Gestión de contactos</h3>
        <ul>
            <li class="bullet">
                <a href="/Contactos">Administración de contactos</a>
            </li>
        </ul>
    </div>
</div>

</body>
</html>
