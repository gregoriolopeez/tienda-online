<?php
class OrderRepository{
    public static function getOrders(){
        $db = DB::connect();
        $query = "SELECT * FROM order";
        $result = $db->query($query);
        $orders = [];
        while($order = $result->fetch_assoc()){
            $orders[] = new Order($order['id'], $order['buyer_id'], $order['total_price'], $order['date'], $order['status']);
        }
        return $orders;
    }
}
?>