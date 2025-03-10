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
              LEFT JOIN likedcomment as lc on c.id = lc.comment_id
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


    public static function add_comments($title, $comment, $userID, $commentedForID, $tableType) {
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
    
    public static function like_comment($userID, $commentID) {
        $db = Database::getDB();
        
        try {
            // Check if the user has already liked this comment
            $query = 'SELECT COUNT(*) FROM likedComment WHERE ccUser_id = :userID AND comment_id = :commentID';
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
            $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);
            $statement->execute();
            $count = $statement->fetchColumn();
            $statement->closeCursor();

            if ($count > 0) {
                // User already liked this comment
                return "User has already liked this comment.";
            }

            // Insert into likedComment table
            $query = 'INSERT INTO likedComment (ccUser_id, comment_id) VALUES (:userID, :commentID)';
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
            $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);
            $statement->execute();
            $statement->closeCursor();

            
        } catch (Exception $e) {
            throw new Exception("Error liking comment: " . $e->getMessage());
        }
    
    }
    
    public static function unlike_comment($userID, $commentID) {
        $db = Database::getDB();
        
        try {
            // Check if the user has already liked this comment
            


            $query = 'DELETE FROM likedComment 
              WHERE ccUser_id = :userID AND comment_id = :commentID';
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
            $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);
            $statement->execute();
            $statement->closeCursor();

            
        } catch (Exception $e) {
            throw new Exception("Error liking comment: " . $e->getMessage());
        }
    
    }
    
    public static function check_if_liked_comment($userID, $commentID) {
        $db = Database::getDB();
        
        try {
            // Check if the user has already liked this comment
            $query = 'SELECT COUNT(*) FROM likedComment WHERE ccUser_id = :userID AND comment_id = :commentID';
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
            $statement->bindValue(':commentID', $commentID, PDO::PARAM_INT);
            $statement->execute();
            $count = $statement->fetchColumn();
            $statement->closeCursor();

            $liked = false;
            if ($count > 0) {
                // User liked this comment
                $liked = true;
            }
            
            return $liked; 
           

            
        } catch (Exception $e) {
            throw new Exception("Error check_if_liked_comment: " . $e->getMessage());
        }
    
    }
    
}
