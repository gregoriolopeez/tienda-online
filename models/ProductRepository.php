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

    public static function addProduct($name, $description, $price, $stock){
        $db = DB::connect();
        $name = $db->real_escape_string(trim($name));
        $description = $db->real_escape_string(trim($description));
        $price = floatval($price);
        $stock = intval($stock);
        $q = "INSERT INTO products (name, description, price, stock) VALUES ('$name', '$description', $price, $stock)";
        if ($db->query($q)) {
            return $db->insert_id;
        }
        return false;
    }

    public static function updateProduct($id, $name, $description, $price, $stock){
        $db = DB::connect();
        $id = intval($id);
        $name = $db->real_escape_string(trim($name));
        $description = $db->real_escape_string(trim($description));
        $price = floatval($price);
        $stock = intval($stock);
        $q = "UPDATE products SET name='$name', description='$description', price=$price, stock=$stock WHERE id=$id";
        return $db->query($q);
    }

    public static function deleteProduct($id){
        $db = DB::connect();
        $id = intval($id);
        try {
            return $db->query("DELETE FROM products WHERE id=$id");
        } catch (\mysqli_sql_exception $e) {
            return false;
        }
    }
}