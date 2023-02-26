<?php

// Clase de la base de datos, con esto nos conectamos a la base de datos
class Database
{
    private $connection;

    public function __construct()
    {
        // Datos de conexión a la base de datos
        $db_host="localhost";
        $db_name="expo";
        $db_user="root";
        $db_password= "";
        
        // Conectarse a la base de datos
        try {
            $this->connection = new PDO("mysql:host=" . $db_host . ";dbname=" . $db_name, $db_user, $db_password);
        } catch (PDOException $pe) {
            // Error de conexión
            $this->connection = null;
        }
    }

    // Método que devuelve la conexión a la base de datos
    public function getConnection()
    {
        return $this->connection;
    }
}