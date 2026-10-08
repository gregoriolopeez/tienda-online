<?php

if(isset($_GET['new'])){
    require_once("views/newProduct.phtml");
    exit;
}

if(isset($_GET['add'])){
$q="INSERT INTO product (nombre, description, price, stock) VALUES ('{$_POST['nombre']}', '{$_POST['descripcion']}', {$_POST['precio']}, {$_POST['stock']})";
$db = DB::connect();
$db->query($q);
header("Location: index.php");
exit;
}
