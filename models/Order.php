<?php
class Order{
    private $id;
    private $user_id; //buyer
    private $product_id; //products
    private $total; //total price
    private $date;
    //añadir status

    public function __construct($id, $user_id, $product_id, $total, $date){ //quitar products
        $this->id=$id;
        $this->user_id=$user_id; //UserRepositoy::getUserById($buyer_id)
        $this->product_id=$product_id; //ProductRepositoy::getProductByOrderId($id)
        $this->total=$total;
        $this->date=$date;
    }

    public function getId(){
        return $this->id;
    }

    public function getUserId(){
        return $this->user_id; 
    }

    public function getProductId(){ //quitar
        return $this->product_id;
    }

    public function getTotal(){
        return $this->total;
    }

    public function getDate(){
        return $this->date;
    }
}
?>