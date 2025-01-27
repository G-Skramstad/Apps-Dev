<?php

class store_db{
    
    public static function getStores(){
        $db = Database::getDB();  
        
        $query = 'SELECT s.ID, s.name, s.isActive 
        FROM store AS s ';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $user = new Store($row['name'], $row['isActive']);
            $user->setId($row['ID']);
            $users[] = $user;
        }

        return $users;    
        
        
}

public static function getActiveStores(){
        $db = Database::getDB();  
        
        $query = 'SELECT s.ID, s.name, s.isActive 
        FROM store AS s 
        WHERE isActive = 1';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $user = new Store($row['name'], $row['isActive']);
            $user->setId($row['ID']);
            $users[] = $user;
        }

        return $users;    
        
        
}

public static function editStore($id,$name){
    $db = Database::getDB();
    
    $query = 'UPDATE store SET name = :name WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':id', $id);
    $statement->execute();
}

public static function deactivateStore($id){
    $db = Database::getDB();
    
    $query = 'Update store set isActive = 0 WHERE id =:id ';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
}
public static function activateStore($id){
    $db = Database::getDB();
    
    $query = 'Update store set isActive = 1 WHERE id =:id ';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
}

public static function addStore($name){
    $db = Database::getDB();
    
    $query = 'INSERT into store (name) VALUES (:name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
}
    
    
}

