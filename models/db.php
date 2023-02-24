<?php

class Database
{
    private $connection;

    public function __construct()
    {
        $db_host="localhost";
        $db_name="expo";
        $db_user="root";
        $db_password= "";
        
        try {
            $this->connection = new PDO("mysql:host=" . $db_host . ";dbname=" . $db_name, $db_user, $db_password);
        } catch (PDOException $pe) {
            $this->connection = null;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}