<?php
    class Comment{
    
    private $id, $title, $comment, $userID, $status, $isFlagged, $commentedOn, $inportant, $dateComented;
  
    public function __construct($title, $comment, $userID, $status, $isFlagged, $commentedOn, $inportant, $dateComented) {
        $this->title = $title;
        $this->comment = $comment;
        $this->userID = $userID;
        $this->status = $status;
        $this->isFlagged = $isFlagged;
        $this->commentedOn = $commentedOn;
        $this->inportant = $inportant;
        $this->dateComented = $dateComented;
    }

    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getIsFlagged() {
        return $this->isFlagged;
    }

    public function getCommentedOn() {
        return $this->commentedOn;
    }

    public function getInportant() {
        return $this->inportant;
    }

    public function getDateComented() {
        return $this->dateComented;
    }

    public function setId($id) {
        $this->id = $id;
    }



    }