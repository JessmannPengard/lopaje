<?php

class User extends Orm
{
    // Constructor
    public function __construct($conn)
    {
        parent::__construct("id_user", "users", $conn);
    }

    // Checks for valid username/password combination and return id_user (0 if not found)
    public function login($userName, $userPassword)
    {
        // Encrypt password
        $pw = md5($userPassword);

        // Prepare
        $stm = $this->dbconn->prepare("SELECT * FROM {$this->table} WHERE 
                user_name=:username AND user_password=:password");
        $stm->bindValue(":username", $userName);
        $stm->bindValue(":password", $pw);

        // Execute
        $stm->execute();

        // True if found, else False
        return $stm->fetch();
    }

    public function register($userName, $userPassword, $userEmail)
    {
        $result = array();

        if ($this->existUsername($userName)) {
            $result["result"] = false;
            $result["msg"] = "This UserName is already in use.";
            return $result;
        }
        if ($this->existEmail($userEmail)) {
            $result["result"] = false;
            $result["msg"] = "This Email is already in use.";
            return $result;
        }

        // Encrypt password
        $pw = md5($userPassword);

        // Prepare
        $stm = $this->dbconn->prepare("INSERT INTO {$this->table} (user_name, user_password, user_email)
                VALUES (:username, :password, :email)");

        $stm->bindValue(":username", $userName);
        $stm->bindValue(":password", $pw);
        $stm->bindValue(":email", $userEmail);

        // Execute
        $stm->execute();
        $result["result"] = true;
        return $result;
    }

    // Checks if the username already exists
    public function existUsername($userName)
    {
        // Prepare
        $stm = $this->dbconn->prepare("SELECT id_user FROM users WHERE user_name = :username");
        $stm->bindValue(":username", $userName);

        // Execute
        $stm->execute();

        // True if username already exists, else False
        return $stm->fetch();
    }

    // Checks if the Email already exists
    public function existEmail($userEmail)
    {
        // Prepare
        $stm = $this->dbconn->prepare("SELECT id_user FROM users WHERE user_email = :user_email");
        $stm->bindValue(":user_email", $userEmail);

        // Execute
        $stm->execute();

        // True if email already exists, else False
        return $stm->fetch();
    }

    // Returns username from id_user
    public function getUsername($id_user)
    {
        $username = "";
        // Prepare
        $stm = $this->dbconn->prepare("SELECT user_name FROM users WHERE id_user = :id_user");
        $stm->bindValue(":id_user", $id_user);
        $stm->bindColumn("user_name", $username);

        // Execute
        $stm->execute();

        // Get username
        $stm->fetch();

        // Return username
        return $username;
    }
}
