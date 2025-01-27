<?php
class user_db{
    public static function get_users() {
        $db = Database::getDB();  
        
        $query = 'SELECT c.ID,c.wlUserRoleID ,c.firstName, c.lastName, c.password, c.email, c.address, c.city,
            c.st, c.zip,c.phone, c.isActive, c.phone 
        FROM wluser AS c ';
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $user = new User($row['email'], $row['password'], 
                    $row['firstName'], $row['lastName'], $row['address'], $row['city'],
                    $row['st'], $row['zip'], $row['isActive'], $row['wlUserRoleID'], $row['phone']);
            $user->setId($row['ID']);
            $users[] = $user;
        }

        return $users;    
    }

    public static function search_users($last_name){
        $db = Database::getDB();  
        $query = 'SELECT c.*
                    FROM wluser c

                     WHERE c.lastName LIKE "%":lastName"%"';
        $statement = $db->prepare($query);
        $statement->bindValue(':lastName', $last_name);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        foreach ($rows as $row){
            $user = new User($row['email'], $row['password'], 
                    $row['firstName'], $row['lastName'], $row['address'], $row['city'],
                    $row['st'], $row['zip'], $row['isActive'], $row['wlUserRoleID'], $row['phone']);
            $user->setId($row['ID']);
            $users[] = $user;
        }

        return $users;   
    }

    public static function get_user_by_email_password($email,$password){
        $db = Database::getDB();  
        $query = 'SELECT * FROM wluser  '
                    . 'WHERE email =  :email AND password = :password';
            $statement = $db->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $password);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
            if ($row){
            $user = new User($row['email'], $row['password'], 
                    $row['firstName'], $row['lastName'], $row['address'], $row['city'],
                    $row['st'], $row['zip'], $row['isActive'], $row['wlUserRoleID'], $row['phone']);
            $user->setId($row['ID']);
            }
            else {$user = null;}

            return $user;
    }

    public static function get_user_by_id($id){
        $db = Database::getDB();  
        $query = 'SELECT * FROM wluser  '
                    . 'WHERE id =  :id';
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();

            $user = new User($row['email'], $row['password'], 
                    $row['firstName'], $row['lastName'], $row['address'], $row['city'],
                    $row['st'], $row['zip'], $row['isActive'], $row['wlUserRoleID'], $row['phone']);

            $user->setId($row['ID']);
            return $user;
    }

    public static function update_user($user){
        $db = Database::getDB();  
         $query = 'Update wluser
                     SET email = :email_address,
                     password =:password,
                     firstName = :firstName,
                     lastName =:LastName,
                     address = :address, 
                     city = :city,
                     st = :state,
                     zip= :postal_code,isActive = :active,
                     phone = :phone,
                     wlUserRoleID = :role
                  where 
                     ID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':email_address', $user-> getEmail());
        $statement->bindValue(':password', $user-> getPasswordC());
        $statement->bindValue(':firstName', $user-> getFirstName());
        $statement->bindValue(':LastName', $user-> getLastName());
        $statement->bindValue(':address', $user-> getAddress());
        $statement->bindValue(':city', $user-> getCity());
        $statement->bindValue(':state', $user-> getState());
        $statement->bindValue(':postal_code', $user-> getZip());
        $statement->bindValue(':id', $user-> getId());
        $statement->bindValue(':active', $user-> getActive());
        $statement->bindvalue(':phone', $user-> getPhone());
        $statement->bindvalue(':role', $user-> getRoleID());
            $statement->execute();
            $statement->closeCursor();
            
            

    }

    public static function add_user($user){
        $db = Database::getDB();  
        $query = 'INSERT INTO wluser
                     (email, password, firstName, LastName, address, city, 
                     st, zip, wlUserRoleID,phone)
                  VALUES
                     (:email_address, :password, :firstName, :LastName, :address,
                     :city, :state, :postal_code,:roleID ,:phone)';
        $statement = $db->prepare($query);
        $statement->bindValue(':email_address', $user-> getEmail());
        $statement->bindValue(':password', $user-> getPasswordC());
        $statement->bindValue(':firstName', $user-> getFirstName());
        $statement->bindValue(':LastName', $user-> getLastName());
        $statement->bindValue(':address', $user-> getAddress());
        $statement->bindValue(':city', $user-> getCity());
        $statement->bindValue(':state', $user-> getState());
        $statement->bindValue(':postal_code', $user-> getZip());
        $statement->bindValue(':roleID', $user-> getRoleID());
        $statement->bindValue(':phone', $user-> getPhone());
            $statement->execute();

            $statement->closeCursor();
            return $user;

    }

    public static function check_in_use_email($email){
        $db = Database::getDB();  
        $query = 'SELECT c.*
                    FROM wluser c

                     WHERE c.email = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $inUseEmail = $statement->fetchAll();
        $statement->closeCursor();
        return $inUseEmail;   
    }
}
?>