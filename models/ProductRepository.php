<?php

class ProductRepository{

    public static function getProducts(){
        $db = DB::connect();
        $result = false;
        try {
            $result = $db->query("SELECT * FROM products");
        } catch (\mysqli_sql_exception $e) {
            try {
                $result = $db->query("SELECT * FROM products");
            } catch (\mysqli_sql_exception $e2) {
                return [];
            }
        }

        $products = [];
        if ($result) {
            while ($product = $result->fetch_assoc()) {
                $products[] = new Product($product['id'], $product['name'], $product['description'], $product['price'], $product['stock']);
            }
        }
        return $products;
    }

    public static function getProductById($id){
        $db = DB::connect();
        $id = intval($id);
        $result = false;
        try {
            $result = $db->query("SELECT * FROM products WHERE id=$id");
        } catch (\mysqli_sql_exception $e) {
            try {
                $result = $db->query("SELECT * FROM product WHERE id=$id");
            } catch (\mysqli_sql_exception $e2) {
                return null;
            }
        }

        if ($result && $product = $result->fetch_assoc()) {
            return new Product($product['id'], $product['name'], $product['description'], $product['price'], $product['stock']);
        }
        return null;
    }
}