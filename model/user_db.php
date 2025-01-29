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

        
        $query = 'SELECT * FROM ccUser 
                  WHERE username = :username AND password = :password';

        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();

        // Check if a user is found, and create the User object
        if ($row) {
            $user = new User(
                $row['email'], 
                $row['password'], 
                $row['username'], // Use the username
                $row['userRoleID'], 
                $row['isActive']
            );
            $user->setId($row['id']);
        } else {
            $user = null; // No user found
        }

        return $user;
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
                      password = :password,
                      username = :username,
                      isActive = :active,
                      phone = :phone,
                      userRoleID = :role
                  WHERE ID = :id';

        $statement = $db->prepare($query);

        // Bind the values from the $user object using relevant getter methods
        $statement->bindValue(':email_address', $user->getEmail());
        $statement->bindValue(':password', $user->getPasswordC());
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

       
        $query = 'INSERT INTO ccUser
                    (email, password, username, userRoleID, isActive, phone)
                  VALUES
                    (:email_address, :password, :username, :roleID, :isActive, :phone)';

        $statement = $db->prepare($query);

        // Bind values from the $user object using the relevant getter methods
        $statement->bindValue(':email_address', $user->getEmail());
        $statement->bindValue(':password', $user->getPasswordC());
        $statement->bindValue(':username', $user->getUserName()); 
        $statement->bindValue(':roleID', $user->getRoleID());
        $statement->bindValue(':isActive', $user->getIsActive()); 
        $statement->bindValue(':phone', $user->getPhone());

        // Execute the query
        $statement->execute();

        $statement->closeCursor();

        return $user; // Return the user object 
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