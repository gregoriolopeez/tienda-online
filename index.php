<?php
$env = parse_ini_file('.env');
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

require_once 'db.php';
require_once 'controllers/mainController.php';

$conexion = db::connect();

?>