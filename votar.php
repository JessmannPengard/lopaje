<?php
// Importamos los modelos necesarios
require_once("./models/db.php");
require_once("./models/imagen.php");
require_once("./models/votacion.php");
require_once("./models/votos.php");

// Iniciamos sesión...
session_start();

// Y comprobamos que el usuario que nos pide el archivo está logueado
if (isset($_SESSION["username"])) {

    $response = "OK";
    // Comprobamos que hayamos recibido los parámetros necesarios para votar
    if (isset($_GET["id_imagen"]) && isset($_GET["id_usuario"]) && isset($_GET["valor"])) {
        //Los guardamos en variables
        $id_imagen = $_GET["id_imagen"];
        $id_usuario = $_GET["id_usuario"];
        $valor = $_GET["valor"];
        // Establecemos la conexión con la base de datos
        $db = new Database();

        // Obtener datos de la imagen para sacar el id_votación
        $imagen = new Imagen($db->getConnection());
        $mi_imagen = $imagen->getById($id_imagen);
        $id_votacion = $mi_imagen["id_votacion"];
        $votacion = new Votacion($db->getConnection());
        $mi_votacion = $votacion->getById($id_votacion);
        // Comprobamos si la votación ya ha finalizado
        $fechaActual = new DateTime("now");
        $fechaFin = new DateTime($mi_votacion["fecha_fin"]);
        $diferencia = $fechaActual->diff($fechaFin);
        // Comprobamos si la votación ya ha finalizado
        if ($diferencia->invert != 0) {
            $finalizada = true;
        } else {
            $finalizada = false;
        }

        if (!$finalizada) {
            // Creamos un objeto Voto
            $voto = new Voto($db->getConnection());

            // Y llamamos al método vote(Votar) o unvote(Eliminar voto) en función de los parámetros recibidos
            if ($valor == 1) {
                $voto->vote($id_imagen, $id_usuario);
            } else {
                $voto->unvote($id_imagen, $id_usuario);
            }
        } else {
            $response = "ERROR";
        }
    }
    echo $response;
}
