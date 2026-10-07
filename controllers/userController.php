<?php

if (isset($_GET['logout'])) {
    session_destroy();
    header('location:index.php');
    exit;
}


if (isset($_POST['login'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $q = "select * from user where email='" . $_POST['username'] . "' OR name='" . $_POST['username'] . "'";

        $db = DB::connect();

        $result = $db->query($q);
        if ($row = $result->fetch_assoc()) {
            if ($row['password'] == md5($_POST['password'])) {

                $_SESSION['user'] = new User($row['id'], $row['name'], $row['email'], $row['password']);
            }
        }
    }
    header('location:index.php');
    exit;
}

if (isset($_POST['register'])) {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']) {
        $q = "insert into user (name, email, password) values ('" . $_POST['name'] . "', '" . $_POST['email'] . "', md5('" . $_POST['password'] . "'))";

        $db = DB::connect();
        $db->query($q);
        if ($db->insert_id) {
            header('location:index.php?login');
            exit();
        }
        header('location:index.php?register');
        exit();
    }
}
