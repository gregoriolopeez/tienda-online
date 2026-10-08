<?php

if(isset($_GET['add'])){

    if(!isset($_SESSION['user'])){
        header('location: index.php?login');
        exit;
    }

    //sacar el producto de la base de datos
    if(isset($_POST['id']) && isset($_POST['quantity'])){
        $product=ProductRepository::getProductById($_POST['id']);

        //tener el pedido en estado carrito del usuario
        $order=OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
        if(!$order){
            $db=DB::connect();
            $buyerId=$_SESSION['user']->getId();
            $db->query("INSERT INTO orders (buyer_id, total_price, date, status) VALUES ($buyerId, 0, NOW(), 0)");
            $order=OrderRepository::getCarritoByUserId($buyerId);
        }

        // crear un orderline en pedido de usuario con producto
        if($order && $product && OrderLineRepository::addOrderLineToOrder($order,$product,$_POST['quantity'])){
            //actualizar total del pedido
            $newTotal= $order->getTotal()+($product->getPrice()*$_POST['quantity']);
            $db=DB::connect();
            $q="UPDATE orders SET total_price=".$newTotal." WHERE id=".$order->getId();
            $db->query($q);

            header('location: index.php?c=order&show');
            exit;
        }

    }
//devolviendo a la vista del carrito
   header('location: index.php');
   exit; 
}

if(isset($_GET['show'])){
       $order=OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
    require_once('views/showOrderView.phtml');
    exit;
}