<?php
class Database{

    private static $dsn = 'mysql:host=localhost;dbname=collabrativecooking';
    private static $username = 'mgs_user';
    private static $password = 'pa55word';
    private static $db;

    private function __construct() {}

    
    public static function getDB () {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                include('../errors/database_error.php');
                exit();
            }
        }
        return self::$db;
    }
    
    public static function logAction($tableName, $action, $userID = null, $description = null) {
    $db = Database::getDB();
    $query = 'INSERT INTO logging (tableName, action, userID, description) 
              VALUES (:tableName, :action, :userID, :description)';
    $statement = $db->prepare($query);
    $statement->execute([
        ':tableName' => $tableName,
        ':action' => $action,
        ':userID' => $userID,
        ':description' => $description
    ]);
    $statement->closeCursor();
}
}
?>