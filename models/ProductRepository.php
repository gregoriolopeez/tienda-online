<?php
class ProductRepository{
    public static function getAllProducts(){
    $db = db::connect();
    $result = $db->query("SELECT * FROM productos");
    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = new Product(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['price'],
            $row['stock']
        );
    }
    
    return $products;
    }
}
?>