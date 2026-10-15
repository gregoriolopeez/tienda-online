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
            $email = $user['email'] ?? '';
            $password = $user['password'] ?? '';
            $role = $user['role'] ?? 'user';
            return new User($user['id'], $username, $email, $password, $role);
        } else {
            return null;
        }
    }

    public static function getUsers(){
        $db = DB::connect();
        $result = false;
        try {
            $result = $db->query("SELECT * FROM users ORDER BY id ASC");
        } catch (\mysqli_sql_exception $e) {
            try {
                $result = $db->query("SELECT * FROM user ORDER BY id ASC");
            } catch (\mysqli_sql_exception $e2) {
                return [];
            }
        }

        $users = [];
        if ($result) {
            while ($user = $result->fetch_assoc()) {
                $username = $user['username'] ?? $user['name'] ?? '';
                $email = $user['email'] ?? '';
                $password = $user['password'] ?? '';
                $role = $user['role'] ?? 'user';
                $users[] = new User($user['id'], $username, $email, $password, $role);
            }
        }
        return $users;
    }
}