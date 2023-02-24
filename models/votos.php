<?php

class Voto
{
    protected $dbconn;

    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Get votes for an image
    public function getById_Image($id_image)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM votos WHERE id_imagen=:id");
        $stm->bindValue(":id", $id_image);
        $stm->execute();
        return $stm->fetchAll();
    }

    // Check if an image has been voted by an user
    public function checkVote($id_image, $id_user)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM votos WHERE id_imagen=:id_image AND id_usuario=:id_user");
        $stm->bindValue(":id_image", $id_image);
        $stm->bindValue(":id_user", $id_user);
        $stm->execute();
        return $stm->fetch();
    }

    // Vote for an image
    public function vote($id_image, $id_user)
    {
        $stm = $this->dbconn->prepare("INSERT INTO votos (id_usuario, id_imagen) VALUES (:id_user, :id_image)");
        $stm->bindValue(":id_user", $id_user);
        $stm->bindValue(":id_image", $id_image);
        $stm->execute();
    }

    // Delete vote
    public function unvote($id_image, $id_user)
    {
        $stm = $this->dbconn->prepare("DELETE FROM votos WHERE id_image=:id_image AND id_user=:id_user");
        $stm->bindValue(":id_image", $id_image);
        $stm->bindValue(":id_user", $id_user);
        $stm->execute();
    }
}
