<?php

require_once("models/User.php");
require_once("models/Product.php");
require_once("models/Cart.php");
require_once("models/Order.php");

require_once("repositories/UserRepository.php");
require_once("repositories/ProductRepository.php");
require_once("repositories/CartRepository.php");
require_once("repositories/OrderRepository.php");

session_start();

if (isset($_GET['logout'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['login'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $q = "SELECT * FROM user WHERE email='" . $_POST['username'] . "' OR name='" . $_POST['username'] . "'";

        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            if ($row['password'] == md5($_POST['password'])) {
                $_SESSION['user'] = new User($row['id'], $row['name'], $row['email'], $row['password']);
            } else $info = "contraseña incorrecta";
        } else $info = "usuario no encontrado";
    }
}

if (isset($_GET['register'])) {
    header("Location: register.php");
    exit();
}
