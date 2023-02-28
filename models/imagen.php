<?php

// Clase que interactúa con la tabla 'imagenes'
class Imagen
{
    protected $dbconn;

    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Obtiene todas las imágenes ordenadas según los parámetros 
    // $orderby ("fecha" o "votos") en el orden especificado $dir ("asc" o "desc")
    public function getAll($orderby, $dir)
    {
        $query = "SELECT imagenes.*, COUNT(votos.id) AS num_votos FROM imagenes 
                    LEFT JOIN votos ON imagenes.id = votos.id_imagen 
                    GROUP BY imagenes.id 
                    ORDER BY " . $orderby . " " . $dir;

        $stm = $this->dbconn->prepare($query);
        $stm->execute();
        return $stm->fetchAll();
    }

    // Obtiene todas las imágenes de una votación determinada
    // ordenadas según los parámetros 
    // $orderby ("fecha" o "votos") en el orden especificado $dir ("asc" o "desc")
    public function getAllbyIdVotacion($idVotacion, $orderby, $dir)
    {
        $query = "SELECT imagenes.*, COUNT(votos.id) AS num_votos FROM imagenes 
                    LEFT JOIN votos ON imagenes.id = votos.id_imagen 
                    WHERE imagenes.id_votacion = :id_votacion 
                    GROUP BY imagenes.id 
                    ORDER BY " . $orderby . " " . $dir;

        $stm = $this->dbconn->prepare($query);
        $stm->bindValue(":id_votacion", $idVotacion);
        $stm->execute();
        return $stm->fetchAll();
    }

    // Obtiene todas las imágenes subidas por el usuario especificado $id_user
    // ordenadas según los parámetros $orderby ("fecha" o "votos")
    // en el orden especificado $dir ("asc" o "desc")
    public function getById_User($id_user, $orderby, $dir)
    {
        $query = "SELECT imagenes.*, COUNT(votos.id) AS num_votos FROM imagenes 
                    LEFT JOIN votos ON imagenes.id = votos.id_imagen 
                    WHERE imagenes.id_usuario=:id_user 
                    GROUP BY imagenes.id 
                    ORDER BY " . $orderby . " " . $dir;

        $stm = $this->dbconn->prepare($query);
        $stm->bindValue(":id_user", $id_user);
        $stm->execute();
        return $stm->fetchAll();
    }

    // Subir imagen: guarda la ruta de la imagen en el servidor y el id de usuario que subió la imagen
    public function upload($id_user, $id_votacion, $url_image)
    {
        $stm = $this->dbconn->prepare("INSERT INTO imagenes (id_usuario, id_votacion, url_imagen) VALUES (:id_user, :id_votacion, :url_image)");
        $stm->bindValue(":id_user", $id_user);
        $stm->bindValue(":id_votacion", $id_votacion);
        $stm->bindValue(":url_image", $url_image);
        $stm->execute();
    }
}