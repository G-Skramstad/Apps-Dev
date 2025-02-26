<?php
    class Comment{
    
    private $id,$comment, $userName,$dateComented,$likes;
  
    public function __construct( $userName, $comment, $dateComented,$likes) {
        
        $this->comment = $comment;
        $this->userName = $userName;
        $this->likes = $likes;

        $this->dateComented = $dateComented;
    }

    
    public function getId() {
        return $this->id;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getDateComented() {
        return $this->dateComented;
    }

    public function getLikes() {
        return $this->likes;
    }

    public function setId($id) {
        $this->id = $id;
    }





    }