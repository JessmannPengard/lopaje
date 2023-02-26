<?php

// Clase para gestionar los usuarios en la tabla "usuarios"
class User
{
    protected $dbconn;

    // Constructor
    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Comprueba que la combinación usuario/contraseña sea correcta
    public function login($userName, $userPassword)
    {
        // Encriptar contraseña
        $pw = md5($userPassword);

        // Prepare
        $stm = $this->dbconn->prepare("SELECT * FROM usuarios WHERE 
                username=:username AND password=:password");
        $stm->bindValue(":username", $userName);
        $stm->bindValue(":password", $pw);

        // Execute
        $stm->execute();

        // Devolver resultado
        return $stm->fetch();
    }

    // Registrar nuevo usuario
    public function register($userName, $userPassword)
    {
        $result = array();

        // Comprueba que el nombre de usuario no exista ya en la base de datos mediante la función existsUsername (declarada más abajo)
        if ($this->existUsername($userName)) {
            // Si existe devolvemos $result=false y el mensaje a mostrar $result="Usuario ya existe"
            $result["result"] = false;
            $result["msg"] = "El nombre de usuario ya existe.";
            return $result;
        }

        // Encriptar password
        $pw = md5($userPassword);

        // Prepare
        $stm = $this->dbconn->prepare("INSERT INTO usuarios (username, password)
                VALUES (:username, :password)");

        $stm->bindValue(":username", $userName);
        $stm->bindValue(":password", $pw);

        // Execute
        $stm->execute();

        // Registrado con éxito
        $result["result"] = true;
        return $result;
    }

    // Comprueba si un nombre de usuario ya existe en la base de datos
    public function existUsername($userName)
    {
        // Prepare
        $stm = $this->dbconn->prepare("SELECT id FROM usuarios WHERE username = :username");
        $stm->bindValue(":username", $userName);

        // Execute
        $stm->execute();

        // Devolvemos el resultado
        return $stm->fetch();
    }

    // Obtiene el nombre de usuario a partir de su id
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

        // Devolvemos el nombre de usuario
        return $username;
    }

    // Obtiene el id de un usuario a partir de su nombre de usuario
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

        // Devolvemos el id
        return $id;
    }
}