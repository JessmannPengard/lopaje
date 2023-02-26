<?php
// Importamos los modelos necesarios
require_once("./models/db.php");
require_once("./models/votos.php");

// Iniciamos sesión...
session_start();

// Y comprobamos que el usuario que nos pide el archivo está logueado
if (isset($_SESSION["username"])) {

    // Comprobamos que hayamos recibido los parámetros necesarios para votar
    if (isset($_GET["id_imagen"]) && isset($_GET["id_usuario"]) && isset($_GET["valor"])) {
        //Los guardamos en variables
        $id_imagen = $_GET["id_imagen"];
        $id_usuario = $_GET["id_usuario"];
        $valor = $_GET["valor"];
        // Establecemos la conexión con la base de datos
        $db = new Database();
        // Creamos un objeto Voto
        $voto = new Voto($db->getConnection());

        // Y llamamos al método vote(Votar) o unvote(Eliminar voto) en función de los parámetros recibidos
        if ($valor == 1) {
            $voto->vote($id_imagen, $id_usuario);
        } else {
            $voto->unvote($id_imagen, $id_usuario);
        }

    }
}