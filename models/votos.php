<?php

// Clase que gestiona los votos, en la tabla "votos"
class Voto
{
    protected $dbconn;

    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Obtiene los votos de una imagen a partir de su id
    public function getById_Image($id_image)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM votos WHERE id_imagen=:id");
        $stm->bindValue(":id", $id_image);
        $stm->execute();
        return $stm->fetchAll();
    }

    // Comprueba si una imagen ya ha sido votada por un usuario, requiere de un id de imagen y un id de usuario
    public function checkVote($id_image, $id_user)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM votos WHERE id_imagen=:id_image AND id_usuario=:id_user");
        $stm->bindValue(":id_image", $id_image);
        $stm->bindValue(":id_user", $id_user);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        $voted = $result ? true : false;

        // Devolvemos el resultado
        return $voted;
    }

    // Votar una imagen, requiere de un id de imagen y de un id de usuario
    public function vote($id_image, $id_user)
    {
        $stm = $this->dbconn->prepare("INSERT INTO votos (id_usuario, id_imagen) VALUES (:id_user, :id_image)");
        $stm->bindValue(":id_user", $id_user);
        $stm->bindValue(":id_image", $id_image);
        $stm->execute();
    }

    // Eliminar voto, requiere de un id de imagen y un id de usuario
    public function unvote($id_image, $id_user)
    {
        $stm = $this->dbconn->prepare("DELETE FROM votos WHERE id_imagen=:id_image AND id_usuario=:id_user");
        $stm->bindValue(":id_image", $id_image);
        $stm->bindValue(":id_user", $id_user);
        $stm->execute();
    }
}