<?php

class UserRepository{

    public static function getUserById($id){
        $db = DB::connect();
        $id = intval($id);
        $result = false;
        try {
            $result = $db->query("SELECT * FROM users WHERE id=$id");
        } catch (\mysqli_sql_exception $e) {
            try {
                $result = $db->query("SELECT * FROM user WHERE id=$id");
            } catch (\mysqli_sql_exception $e2) {
                return null;
            }
        }

        if ($result && $user = $result->fetch_assoc()) {
            $username = $user['username'] ?? $user['name'] ?? '';
            return new User($user['id'], $username);
        } else {
            return null;
        }
    }
}