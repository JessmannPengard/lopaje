<?php

// Clase que gestiona las votaciones, en la tabla "votaciones"
class Votacion
{
    protected $dbconn;

    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Obtiene todas las votaciones
    public function getAll($orderby, $dir)
    {
        $query = "SELECT * FROM votaciones ORDER BY " . $orderby . " " . $dir;
        $stm = $this->dbconn->prepare($query);
        $stm->execute();
        return $stm->fetchAll();
    }

    // Obtiene la votación a partir de su id
    public function getById($id_votacion)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM votaciones WHERE id=:id");
        $stm->bindValue(":id", $id_votacion);
        $stm->execute();
        return $stm->fetch();
    }

    // Obtiene la votación a partir del id de usuario
    public function getByIdUser($id_usuario, $orderby, $dir)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM votaciones WHERE id_usuario=:id
                                        ORDER BY " . $orderby . " " . $dir);
        $stm->bindValue(":id", $id_usuario);
        $stm->execute();
        return $stm->fetchAll();
    }

    // Crea una nueva votación
    public function new($titulo, $descripcion, $fechaInicio, $fechaFin, $id_usuario)
    {
        $stm = $this->dbconn->prepare("INSERT INTO votaciones (titulo, descripcion, fecha_inicio, fecha_fin, id_usuario) 
                                    VALUES (:titulo, :descripcion, :fecha_inicio, :fecha_fin, :id_usuario)");
        $stm->bindValue(":titulo", $titulo);
        $stm->bindValue(":descripcion", $descripcion);
        $stm->bindValue(":fecha_inicio", $fechaInicio);
        $stm->bindValue(":fecha_fin", $fechaFin);
        $stm->bindValue(":id_usuario", $id_usuario);
        $stm->execute();

        // Creada con éxito
        $result["result"] = true;
        return $result;
    }

    // Modifica una votación
    public function updateById($id_votacion, $titulo, $descripcion, $fechaInicio, $fechaFin)
    {
        $stm = $this->dbconn->prepare("UPDATE votacion SET titulo=:titulo, descripcion=:descripcion, fecha_inicio=:fecha_inicio, fecha_fin=:fecha_fin WHERE id=:id");
        $stm->bindValue(":titulo", $titulo);
        $stm->bindValue(":descripcion", $descripcion);
        $stm->bindValue(":fecha_inicio", $fechaInicio);
        $stm->bindValue(":fecha_fin", $fechaFin);
        $stm->bindValue(":id", $id_votacion);
        $stm->execute();
    }

    // Elimina una votación
    public function deleteById($id_votacion)
    {
        $stm = $this->dbconn->prepare("DELETE FROM votacion WHERE id=:id");
        $stm->bindValue(":id", $id_votacion);
        $stm->execute();
    }
}
