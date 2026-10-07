<?php

//cargar modelos
require_once("models/User.php");
require_once("models/Product.php");
require_once("models/Order.php");
require_once("models/OrderLine.php");
require_once("models/ProductRepository.php");
require_once("models/OrderRepository.php");
require_once("models/OrderLineRepository.php");
require_once("models/UserRepository.php");

session_start();

if(isset($_GET['c'])){
    require_once("controllers/".$_GET['c']."Controller.php");
}

//acciones

//listar productos
if (isset($_GET['products']) || isset($_GET['listar'])) {
    $products = ProductRepository::getProducts();
    require_once("views/mainView.phtml");
    exit;
}

//ver login
if(isset($_GET['login'])){
    require_once('views/login.phtml');
    exit;
}

//hacer login
if (isset($_POST['login'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $q = "SELECT * FROM user WHERE email='" . $_POST['username'] . "' OR name='" . $_POST['username'] . "'";
        $db = db::connect();
        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            if ($row['password'] == md5($_POST['password'])) {
                $_SESSION['user'] = new User($row['id'], $row['name'], $row['email'], $row['password']);
            }
        }
    }
    header('location:index.php');
    exit;
}

//logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('location:index.php');
    exit;
}

//register
if(isset($_GET['register'])){
    require_once('views/register.phtml');
    exit;
}

//hacer register
if (isset($_POST['register'])) {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']) {
        $q = "INSERT INTO user (name, email, password) VALUES ('" . $_POST['name'] . "', '" . $_POST['email'] . "', md5('" . $_POST['password'] . "'))";
        $db = db::connect();
        $db->query($q);
        if ($db->insert_id) {
            header('location:index.php?login');
            exit;
        }
        header('location:index.php?register');
        exit;
    }
}

//añadir al carrito
if (isset($_GET['addCart']) || isset($_GET['add_to_cart']) || (isset($_GET['cart']) && isset($_GET['id']))) {
    $productId = $_GET['addCart'] ?? $_GET['add_to_cart'] ?? $_GET['id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]++;
    } else {
        $_SESSION['cart'][$productId] = 1;
    }
    header('location:index.php');
    exit;
}

//terminar pedido
if (isset($_GET['order']) || isset($_GET['terminarPedido']) || isset($_GET['checkout'])) {
    if (!isset($_SESSION['user'])) {
        header('location:index.php?login');
        exit;
    }
    if (!empty($_SESSION['cart'])) {
        $db = db::connect();
        $buyerId = $_SESSION['user']->getId();
        $totalPrice = 0;

        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $res = $db->query("SELECT price FROM product WHERE id = " . intval($productId));
            if ($res && $p = $res->fetch_assoc()) {
                $totalPrice += $p['price'] * $quantity;
            }
        }

        $now = date('Y-m-d H:i:s');
        $inserted = $db->query("INSERT INTO orders (user_id, total, ordered_at, status) VALUES ($buyerId, $totalPrice, '$now', 'pending')");
        if (!$inserted) {
            $db->query("INSERT INTO `order` (buyer_id, total_price, date, status) VALUES ($buyerId, $totalPrice, '$now', 'pending')");
        }
        $orderId = $db->insert_id;

        if ($orderId) {
            foreach ($_SESSION['cart'] as $productId => $quantity) {
                $res = $db->query("SELECT price FROM product WHERE id = " . intval($productId));
                $price = ($res && $p = $res->fetch_assoc()) ? $p['price'] : 0;
                $db->query("INSERT INTO order_item (order_id, product_id, quantity, unit_price) VALUES ($orderId, " . intval($productId) . ", $quantity, $price)");
            }
        }
        unset($_SESSION['cart']);
    }
    header('location:index.php');
    exit;
}


// vista por defecto

$products=ProductRepository::getProducts();

require_once("views/mainView.phtml");

?>