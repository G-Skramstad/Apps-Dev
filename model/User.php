<?php
class User{
    
    private $id, $email, $passwordC, $userName, $roleID,$isActive,$phone; 
    
    public function __construct($email, $passwordC, $userName, $roleID,$isActive) {
        $this->email = $email;
        $this->passwordC = $passwordC;
        $this->userName = $userName;
        $this->roleID = $roleID;
        $this->isActive = $isActive;
    }

    
    public function getPhone() {
        return $this->phone;
    }

    
    public function getIsActive() {
        return $this->isActive;
    }

        public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPasswordC() {
        return $this->passwordC;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getRoleID() {
        return $this->roleID;
    }

    public function setId($id) {
        $this->id = $id;
    }


    
}


/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

