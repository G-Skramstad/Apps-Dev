<?php
class user_db{
    public static function get_users() {
        $db = Database::getDB();  

        $query = 'SELECT c.ID, c.userRoleID, c.username, c.password, c.email, c.phone, c.isActive, c.dateCreated
                  FROM ccUser AS c';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        $users = []; // Initialize the $users array

        foreach ($rows as $row){
            
            $user = new User(
                $row['email'], 
                $row['password'], 
                $row['username'],
                $row['userRoleID'],
                $row['isActive']
                
            );
            $user->setId($row['ID']);
            $users[] = $user;
        }

        return $users;  
    }

    public static function search_users($user_name) {
    $db = Database::getDB();  

   
    $query = 'SELECT c.* 
              FROM ccUser c 
              WHERE c.username LIKE :userName';
    
    $statement = $db->prepare($query);

    // Bind the username parameter with wildcards for partial matching
    $statement->bindValue(':userName', '%' . $user_name . '%');
    $statement->execute();
    
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $users = []; // Initialize the users array

    // Loop through the results and create a new User object using the constructor
    foreach ($rows as $row) {
        
        $user = new User(
            $row['email'], 
            $row['password'], 
            $row['username'], 
            $row['userRoleID'], 
            $row['isActive']
        );

        // Assuming there's a setId method to set the ID from the database
        $user->setId($row['id']); 
        $users[] = $user;
    }

    return $users;   
}


    public static function get_user_by_userName_password($username, $password) {
    $db = Database::getDB();

    $query = 'SELECT * FROM ccUser WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();

    if ($row) {
        $salt = $row['salt'];
        $combined = $password . $salt;
        $hashedPassword = $row['hash'];

        // Use password_verify to validate combined input with stored hash
        if (password_verify($combined, $hashedPassword)) {
            $user = new User(
                
                $row['email'], 
                $row['hash'], 
                $row['username'], 
                $row['userRoleID'], 
                $row['isActive']
            );
            $user->setId($row['id']);
            return $user;
        }
    }

    return null; // Login failed
}


    public static function get_user_by_id($id) {
        $db = Database::getDB();  

        
        $query = 'SELECT * FROM ccUser WHERE ID = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        // Create the User object based on the returned row
        $user = new User(
            $row['email'], 
            $row['password'], 
            $row['username'], 
            $row['userRoleID'], 
            $row['isActive']
        );

        // Set the ID for the user object
        $user->setId($row['id']);

        return $user;
    }


    public static function update_user($user) {
        $db = Database::getDB();  

        
        $query = 'UPDATE ccUser
                  SET email = :email_address,
                      
                      username = :username,
                      isActive = :active,
                      phone = :phone,
                      userRoleID = :role
                  WHERE ID = :id';

        $statement = $db->prepare($query);

        // Bind the values from the $user object using relevant getter methods
        $statement->bindValue(':email_address', $user->getEmail());
     
        $statement->bindValue(':username', $user->getUserName()); 
        $statement->bindValue(':active', $user->getIsActive());
        $statement->bindValue(':phone', $user->getPhone());
        $statement->bindValue(':role', $user->getRoleID());
        $statement->bindValue(':id', $user->getId());

        // Execute the update query
        $statement->execute();
        $statement->closeCursor();
    }


    public static function add_user($user) {
    $db = Database::getDB();

    // Generate a 32-byte salt and encode it
    $salt = base64_encode(random_bytes(32)); 
    
    // Combine the password and salt, then hash it
    $combined = $user->getPasswordC() . $salt;
    $hashedPassword = password_hash($combined, PASSWORD_DEFAULT);

    $query = 'INSERT INTO ccUser (email, hash, username, userRoleID, isActive, phone, salt)
              VALUES (:email_address, :hash, :username, :roleID, :isActive, :phone, :salt)';

    $statement = $db->prepare($query);
    $statement->bindValue(':email_address', $user->getEmail());
    $statement->bindValue(':hash', $hashedPassword);
    $statement->bindValue(':username', $user->getUserName()); 
    $statement->bindValue(':roleID', $user->getRoleID());
    $statement->bindValue(':isActive', $user->getIsActive()); 
    $statement->bindValue(':phone', $user->getPhone());
    $statement->bindValue(':salt', $salt);

    $statement->execute();
    $statement->closeCursor();

    return $user;
}



    public static function check_in_use_username($username) {
        $db = Database::getDB();  

        
        $query = 'SELECT c.* 
                  FROM ccUser c 
                  WHERE c.username = :username';

        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $inUseUsername = $statement->fetchAll();
        $statement->closeCursor();

        // Return whether the username is in use
        return $inUseUsername;
    }
    
    public static function check_in_use_email($email) {
        $db = Database::getDB();  

        
        $query = 'SELECT c.* 
                  FROM ccUser c 
                  WHERE c.email = :email';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $inUseUsername = $statement->fetchAll();
        $statement->closeCursor();

        // Return whether the username is in use
        return $inUseUsername;
    }

}
?>