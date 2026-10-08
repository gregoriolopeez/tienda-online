<?php

#[\AllowDynamicProperties]
class User{

    private $id;
    private $username;
    public $name;
    public $email;
    public $password;
  
    public function __construct($id, $username = '', $email = '', $password = '') {
        $this->id = $id;
        $this->username = $username;
        $this->name = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username ?? $this->name ?? '';
    }

    public function getName() {
        return $this->username ?? $this->name ?? '';
    }

    public function getEmail() {
        return $this->email ?? '';
    }

}