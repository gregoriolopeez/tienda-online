<?php
$env = parse_ini_file('.env');
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

require_once 'db.php';
$db = db::connect();
require_once 'controllers/mainControllers.php';
?>