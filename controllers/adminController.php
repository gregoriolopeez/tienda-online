<?php

// Proteger el panel: Solo usuarios con rol 'admin' pueden acceder
if (!isset($_SESSION['user']) || !$_SESSION['user']->isAdmin()) {
    header('Location: index.php');
    exit;
}

// Manejo opcional de cambio de estado de un pedido
if (isset($_POST['action']) && $_POST['action'] === 'update_order_status' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = intval($_POST['status']);
    OrderRepository::updateStatus($orderId, $newStatus);
    header('Location: index.php?c=admin#ordersSection');
    exit;
}

$users = UserRepository::getUsers();
$orders = OrderRepository::getOrders();

require_once('views/adminView.phtml');
exit;
