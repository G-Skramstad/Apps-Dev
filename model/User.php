<?php
class User{
    
    private $id, $email, $passwordC, $firstName, $lastName, $address, $city, $state, $zip, $active, $roleID, $phone; 
    
    public function __construct($email, $passwordC, $firstName, $lastName, $address, $city, $state, $zip, $active, $roleID, $phone) {
        $this->email = $email;
        $this->passwordC = $passwordC;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
        $this->active = $active;
        $this->roleID = $roleID;
        $this->phone = $phone; 
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

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getZip() {
        return $this->zip;
    }

    public function getActive() {
        return $this->active;
    }
    public function getRoleID() {
        return $this->roleID;
    }

    public function getPhone() {
        return $this->phone;
    }

    
    public function setId($id) {
        $this->id = $id;
    }

    public function getName(){
        return $this-> firstName." ".$this->lastName;
    }

    
}


/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

