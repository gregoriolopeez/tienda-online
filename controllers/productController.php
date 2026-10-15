<?php

// Proteger las acciones de administración de productos
if (!isset($_SESSION['user']) || !$_SESSION['user']->isAdmin()) {
    header("Location: index.php");
    exit;
}

// Vista de formulario para nuevo producto
if (isset($_GET['new'])) {
    require_once("views/newProduct.phtml");
    exit;
}

// Procesar alta de producto
if (isset($_GET['add'])) {
    if (!empty($_POST['name']) && isset($_POST['price']) && isset($_POST['stock'])) {
        $name = $_POST['name'];
        $description = $_POST['description'] ?? '';
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);

        $inserted = ProductRepository::addProduct($name, $description, $price, $stock);
        if ($inserted) {
            header("Location: index.php?c=product&manage&created=1");
            exit;
        }
    }
    header("Location: index.php?c=product&new&error=1");
    exit;
}

// Vista para editar un producto
if (isset($_GET['edit'])) {
    $productId = intval($_GET['edit']);
    $product = ProductRepository::getProductById($productId);
    if (!$product) {
        header("Location: index.php?c=product&manage&error=1");
        exit;
    }
    require_once("views/editProduct.phtml");
    exit;
}

// Procesar actualización de producto
if (isset($_GET['update'])) {
    if (!empty($_POST['id']) && !empty($_POST['name']) && isset($_POST['price']) && isset($_POST['stock'])) {
        $id = intval($_POST['id']);
        $name = $_POST['name'];
        $description = $_POST['description'] ?? '';
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);

        $updated = ProductRepository::updateProduct($id, $name, $description, $price, $stock);
        if ($updated) {
            header("Location: index.php?c=product&manage&updated=1");
            exit;
        }
    }
    header("Location: index.php?c=product&manage&error=1");
    exit;
}

// Procesar eliminación de producto
if (isset($_GET['delete'])) {
    $productId = intval($_GET['delete']);
    if ($productId > 0) {
        $deleted = ProductRepository::deleteProduct($productId);
        if ($deleted) {
            header("Location: index.php?c=product&manage&deleted=1");
            exit;
        }
    }
    header("Location: index.php?c=product&manage&error=1");
    exit;
}

// Vista por defecto: Listado y gestión de productos para admin
$products = ProductRepository::getProducts();
require_once("views/productsAdminView.phtml");
exit;
