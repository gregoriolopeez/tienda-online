<?php

#[\AllowDynamicProperties]
class User{

    private $id;
    private $username;
    public $name;
    public $email;
    public $password;
    public $role;
  
    public function __construct($id, $username = '', $email = '', $password = '', $role = 'user') {
        $this->id = $id;
        $this->username = $username;
        $this->name = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role ?: 'user';
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

    public function getRole() {
        return $this->role ?? 'user';
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function isAdmin() {
        return ($this->role ?? 'user') === 'admin';
    }

}