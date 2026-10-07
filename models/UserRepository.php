<?php
class UserRepository {
    public static function getUserById($id) { //esto lo ha hecho la IA, hay q revisarlo
        $db = DB::connect();
        $query = "SELECT * FROM user WHERE id = $id";
        $result = $db->query($query);
        if($user = $result-> fetch_assoc()) {
            return new User($user['id'], $user['name'], $user['email'], $user['password']);
        } else {
            return null;
        }
    }
}