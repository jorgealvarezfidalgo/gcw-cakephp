<?php
$admin_path = isset($_GET['admin_path'])? $_GET['admin_path']: '';

$config = [
    [
        "title" => "Botón",
        "description" => "Enlace con estilo",
        "url" => $admin_path . "/js/vendors/tinymce/templates/button.html"
    ]
];

echo json_encode($config);
