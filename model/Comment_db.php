<?php

class Comment_db{
    
    public static function get_comments($tableType, $commentedForID) {
    $db = Database::getDB();

    $query = 'SELECT c.id, u.username, c.comment, c.dateCreated, 
                     cl.tableType, cl.commentedForID
                     COUNT(lc.comment_id) AS likeCount
              FROM comment AS c
              JOIN commentLink AS cl ON c.id = cl.commentID
              JOIN ccuser as u on u.id = c.ccUser_id
              WHERE cl.tableType = :tableType AND cl.commentedForID = :commentedForID
              GROUP BY c.id, u.username, c.comment, c.dateCreated, cl.tableType, cl.commentedForID';

    $statement = $db->prepare($query);
    $statement->bindValue(':tableType', $tableType);
    $statement->bindValue(':commentedForID', $commentedForID);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    
    
    $comments = [];
    foreach ($rows as $row) {
        $comment = new Comment($row['username'], $row['commentText'], $row['dateAdded']);
        $comment->setId($row['id']);
        $comments[] = $comment;
    }

    return $comments;
}

    
    
    
    
    
    
    
}
