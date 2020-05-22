<?php
class DBManager
{ 
    private static $instance = null;
    private $conn;
    
    private $host = "localhost"; //da modificare
    private $user = 'app';
    private $pass = 'appdbpasswd';
    private $database = 'flixy';
    
    // The db connection is established in the private constructor.
    private function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->database);
        if ($this->conn->connect_errno) {
            die("Connection to db failed");
        }
    }
    
    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new DBManager();
        }
    
        return self::$instance;
    }
    
    public function getConnection()
    {
        return $this->conn;
    }

    public function fetchObject($className, $id)
    {
        $result = $this->query("SELECT * FROM ".$className." WHERE id = ".$id.";", $className);
        if (count($result) == 1)
        {
            return $result[0];
        }
        return null;
    }

    public function deleteObject($id, $className)
    {
        $result = $this->query("DELETE FROM ".$className." WHERE id=".$id);
        return $result;
    }

    public function login($username, $password)
    {
        $hashedPassword = hash('sha256', $password);
        $result = $this->query("SELECT Keychain.user_id, Keychain.can_publish FROM Keychain WHERE Keychain.username ='{$username}' AND Keychain.password = '{$hashedPassword}';");
        if (count($result) == 1)
        {
            // user credentials found
            $userId = (int)$result[0]->user_id;
            $canPublish = (int)$result[0]->can_publish;
            SessionManager::startSessionForUser($userId, $username, $canPublish);
            return $userId;
        }
        return false;
    }

    public function register($username, $password, $name, $surname, $email)
    {
        $hashedPassword = hash('sha256', $password);
        $this->conn->begin_transaction();
        $this->conn->query("INSERT INTO `User` (`name`, `surname`, `email`) VALUES ('{$name}', '{$surname}', '{$email}');");
        $keyId = $this->conn->insert_id;
        $this->conn->query("INSERT INTO `Keychain` (`user_id`, `username`, `password`) VALUES ({$keyId}, '{$username}', '{$hashedPassword}');");
        if ($this->conn->commit())
            return self::login($username,$password);
        else {
            $this->conn->rollback();
            return false;
        }
    }

    public function query($queryString, $className = "stdClass")
    {
        $results = [];
        $res = $this->conn->query($queryString);
        if ($res == false)
            return null;
        if ($res === true || $res === false)
        {
            return $res;
        }
        while ($row = $res->fetch_object($className)) {
            array_push($results, $row);
        }
        return $results;
    }
    
    function __destruct() {
        $this->conn->close();
    }
}

?>