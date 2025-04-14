<?php
    class Comment{
    
    private $id,$comment, $title,$userName,$dateComented,$likes;
  
    public function __construct( $userName, $comment, $title,$dateComented,$likes) {
        
        $this->comment = $comment;
        $this->userName = $userName;
        $this->likes = $likes;
        $this->title = $title;
        $this->dateComented = $dateComented;
    }

    public function getTitle() {
        return $this->title;
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