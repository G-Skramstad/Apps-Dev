<?php

class Comment_db{
    
    public static function get_comments($tableType, $commentedForID) {
    $db = Database::getDB();

    $query = 'SELECT c.id, u.username, c.comment, c.dateCreated, 
                     cl.tableType, cl.commentedForID,
                     COUNT(lc.comment_id) AS likeCount
              FROM comment AS c
              JOIN commentLink AS cl ON c.id = cl.commentID
              JOIN ccuser as u on u.id = c.ccUser_id
              JOIN likedcomment as lc on c.id = lc.comment_id
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
        $comment = new Comment($row['username'], $row['comment'], 
                $row['dateCreated'], $row['likeCount']);
        $comment->setId($row['id']);
        $comments[] = $comment;
    }

    return $comments;
}


    public static function add_comments($title, $comment, $userId, $commentedForID, $tableType) {
        $db = Database::getDB();
        
        try {
            $db->beginTransaction();

            // Insert into comment table
            $query = 'INSERT INTO comment (title, ccUser_id, comment) 
                      VALUES (:title, :userID, :comment)';
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title, PDO::PARAM_STR);
            $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
            $statement->bindValue(':comment', $comment, PDO::PARAM_STR);
            $statement->execute();

            // Get the last inserted comment ID
            $commentID = $db->lastInsertId();

            // Insert into commentLink table to associate the comment
            $query2 = 'INSERT INTO commentLink (commentID, tableType, commentedForID) 
                      VALUES (:commentID, :tableType, :commentedForID)';
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(':commentID', $commentID, PDO::PARAM_INT);
            $statement2->bindValue(':tableType', $tableType, PDO::PARAM_STR);
            $statement2->bindValue(':commentedForID', $commentedForID, PDO::PARAM_INT);
            $statement2->execute();

            // Commit the transaction
            $db->commit();
            
            $statement->closeCursor();
            $statement2->closeCursor();
            return $commentID;
        } catch (Exception $e) {
            $db->rollBack();
            throw new Exception("Error inserting comment: " . $e->getMessage());
        }
    
    
    
    
    }
    
    
    
    
}
