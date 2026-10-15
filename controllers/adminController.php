<?php

// Proteger el panel: Solo usuarios con rol 'admin' pueden acceder
if (!isset($_SESSION['user']) || !$_SESSION['user']->isAdmin()) {
    header('Location: index.php');
    exit;
}

$users = UserRepository::getUsers();

require_once('views/adminView.phtml');
exit;
