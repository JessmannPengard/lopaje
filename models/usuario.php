<?php

class User
{
    protected $dbconn;

    // Constructor
    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Checks for valid username/password combination and return id_user (0 if not found)
    public function login($userName, $userPassword)
    {
        // Encrypt password
        $pw = md5($userPassword);

        // Prepare
        $stm = $this->dbconn->prepare("SELECT * FROM usuarios WHERE 
                username=:username AND password=:password");
        $stm->bindValue(":username", $userName);
        $stm->bindValue(":password", $pw);

        // Execute
        $stm->execute();

        // True if found, else False
        return $stm->fetch();
    }

    // Register new user
    public function register($userName, $userPassword)
    {
        $result = array();

        // Check for existing username
        if ($this->existUsername($userName)) {
            $result["result"] = false;
            $result["msg"] = "El nombre de usuario ya existe.";
            return $result;
        }

        // Encrypt password
        $pw = md5($userPassword);

        // Prepare
        $stm = $this->dbconn->prepare("INSERT INTO usuarios (username, password)
                VALUES (:username, :password)");

        $stm->bindValue(":username", $userName);
        $stm->bindValue(":password", $pw);

        // Execute
        $stm->execute();
        $result["result"] = true;
        return $result;
    }

    // Checks if the username already exists
    public function existUsername($userName)
    {
        // Prepare
        $stm = $this->dbconn->prepare("SELECT id FROM usuarios WHERE username = :username");
        $stm->bindValue(":username", $userName);

        // Execute
        $stm->execute();

        // True if username already exists, else False
        return $stm->fetch();
    }

    // Returns username from id_user
    public function getUsername($id_user)
    {
        $username = "";
        // Prepare
        $stm = $this->dbconn->prepare("SELECT username FROM usuarios WHERE id = :id_user");
        $stm->bindValue(":id_user", $id_user);
        $stm->bindColumn("username", $username);

        // Execute
        $stm->execute();

        // Get username
        $stm->fetch();

        // Return username
        return $username;
    }

    // Returns username from id_user
    public function getId($username)
    {
        $id = 0;
        // Prepare
        $stm = $this->dbconn->prepare("SELECT id FROM usuarios WHERE username = :username");
        $stm->bindValue(":username", $username);
        $stm->bindColumn("id", $id);

        // Execute
        $stm->execute();

        // Get username
        $stm->fetch();

        // Return username
        return $id;
    }
}