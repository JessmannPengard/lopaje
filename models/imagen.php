<?php

class Imagen
{
    protected $dbconn;

    public function __construct($conn)
    {
        $this->dbconn = $conn;
    }

    // Get all images
    public function getAll()
    {
        $stm = $this->dbconn->prepare("SELECT * FROM imagenes ORDER BY fecha DESC");
        $stm->execute();
        return $stm->fetchAll();
    }

    // Get images from user
    public function getById_User($id_user)
    {
        $stm = $this->dbconn->prepare("SELECT * FROM imagenes WHERE id_isuario=:id_user ORDER BY fecha DESC");
        $stm->bindValue(":id_user", $id_user);
        $stm->execute();
        return $stm->fetchAll();
    }

    // Upload image
    public function upload($id_user, $url_image)
    {
        $stm = $this->dbconn->prepare("INSERT INTO imagenes (id_usuario, url_imagen) VALUES (:id_user, :url_image)");
        $stm->bindValue(":id_user", $id_user);
        $stm->bindValue(":url_image", $url_image);
        $stm->execute();
    }
}
