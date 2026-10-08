<?php

if(isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
    exit;
}

if(isset($_POST['login'])){
    if(isset($_POST['username']) && isset($_POST['password'])){
        $db = DB::connect();
        $userParam = $db->real_escape_string($_POST['username']);
        $passHash = md5($_POST['password']);
        
        $result = false;
        try {
            $result = $db->query("SELECT * FROM users WHERE username='$userParam'");
        } catch (\mysqli_sql_exception $e) {
            try {
                $result = $db->query("SELECT * FROM user WHERE email='$userParam' OR name='$userParam'");
            } catch (\mysqli_sql_exception $e2) {
                $result = false;
            }
        }

        if($result && $row = $result->fetch_assoc()){
            if($row['password'] == $passHash){
                $username = $row['username'] ?? $row['name'] ?? $_POST['username'];
                $email = $row['email'] ?? '';
                $_SESSION['user'] = new User($row['id'], $username, $email, $row['password']);
            }
        }
    }
    header('location:index.php');
    exit;
}

if(isset($_POST['register'])){
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']){
        $db = DB::connect();
        $userParam = $db->real_escape_string($_POST['username']);
        $passHash = md5($_POST['password']);

        $inserted = false;
        try {
            $inserted = $db->query("INSERT INTO users VALUES (NULL, '$userParam', '$passHash')");
        } catch (\mysqli_sql_exception $e) {
            try {
                $inserted = $db->query("INSERT INTO user (name, email, password) VALUES ('$userParam', '$userParam@tienda.com', '$passHash')");
            } catch (\mysqli_sql_exception $e2) {
                $inserted = false;
            }
        }

        if($inserted && $db->insert_id){
            header('location:index.php?login');
            exit();
        }
        header('location:index.php?register');
        exit();
    }
}