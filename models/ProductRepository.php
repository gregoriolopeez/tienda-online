<?php
class ProductRepository{
    public static function getProducts(){
    $db = DB::connect();
    $query = "SELECT * FROM product";
        $result = $db->query($query);
        $products = [];
        while($product = $result->fetch_assoc()){
            $products[] = new Product($product['id'], $product['name'], $product['description'], $product['price'], $product['stock']);
        }
        return $products;
    }
}
?>