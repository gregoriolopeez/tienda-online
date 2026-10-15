<?php

class OrderRepository{

    public static function getOrderById($id){
        $db=DB::connect();
        $query="SELECT * FROM orders WHERE id=".$id;
        $result=$db->query($query);
        $order=$result->fetch_assoc();
        return new Order($order['id'], $order['buyer_id'], $order['total_price'], $order['date'], $order['status'] );
 
    }

    public static function getCarritoByUserId($id){
        $db=DB::connect();
        $q='SELECT * from orders where status=0 and buyer_id='.$id;
        $result=$db->query($q);
        if($row=$result->fetch_assoc()){
            return new Order($row['id'], $row['buyer_id'], $row['total_price'], $row['date'], $row['status']);
        }
        return false;
    }

    public static function recalculateTotal($orderId){
        $db = DB::connect();
        $orderId = intval($orderId);
        $res = $db->query("SELECT SUM(quantity * price) AS total FROM order_lines WHERE order_id = $orderId");
        $total = 0.00;
        if($res && $row = $res->fetch_assoc()){
            $total = floatval($row['total'] ?? 0);
        }
        $db->query("UPDATE orders SET total_price = $total WHERE id = $orderId");
        return $total;
    }

    public static function getOrders(){
        $db = DB::connect();
        $orders = [];
        try {
            $result = $db->query("SELECT * FROM orders ORDER BY id DESC");
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $orders[] = new Order($row['id'], $row['buyer_id'], $row['total_price'], $row['date'], $row['status']);
                }
            }
        } catch (\mysqli_sql_exception $e) {
            return [];
        }
        return $orders;
    }

    public static function updateStatus($orderId, $status){
        $db = DB::connect();
        $orderId = intval($orderId);
        $status = intval($status);
        return $db->query("UPDATE orders SET status = $status WHERE id = $orderId");
    }
}