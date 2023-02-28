<?php

// Iniciamos sesión y comprobamos si el usuario está logueado, en caso contrario lo redirigimos al login
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

// Importamos los modelos necesarios
require("./models/db.php");
require("./models/usuario.php");
require("./models/votacion.php");

// Inicializamos la variable que usaremos para mostrar mensajes en caso de algún error
$msg = "";

// Si nos están enviando el formulario...
if (isset($_POST["titulo"])) {
    // Obtenemos los datos de $_POST
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    // Nos conectamos a la base de datos
    $db = new Database();
    $user = new User($db->getConnection());
    $id_user = $user->getId($_SESSION["username"]);
    $votacion = new Votacion($db->getConnection());

    // Y llamamos al método para crear una nueva votación
    $vot = $votacion->new($titulo, $descripcion, $fecha_inicio, $fecha_fin, $id_user);
    // Si el resultado es positivo
    if ($vot["result"]) {
        // Registro correcto, redirigimos al index
        header("Location: index.php");
    } else {
        // Error en la creación, guardamos el mensaje de error a mostrar más abajo
        $msg = $vot["msg"];
    }
}

?>

<!-- Cabecera de página -->
<?php
require_once("./layout/header.php");
?>

<!-- Contenido de la página -->
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <!-- Título del formulario -->
            <h2>Crear votación</h2>
            <!-- Formulario de registro -->
            <form action="" method="post" class="login-form" id="registerForm">
                <div class="form-group">
                    <label for="titulo" class="form-label ">Título</label>
                    <input type="text" name="titulo" class="form-control" required placeholder="Título" autofocus>
                </div>
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" maxlength="255" class="form-control" rows="6" resize="none" required
                        placeholder="Descripción"></textarea>
                </div>
                <div class="form-group">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha-inicio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin" class="form-label">Fecha de finalización</label>
                    <input type="date" name="fecha_fin" id="fecha-fin" class="form-control" required>
                </div>
                <!-- Mostramos el mensaje de error, si lo hubiera, si no estaría vacío "" -->
                <div class="form-group">
                    <p class="error-text" id="error"></p>
                </div>
                <button type="submit" onclick="validarFechas(event)" value="" class="btn btn-primary">Crear</button>
                <a href="index.php"><button type="button" class="btn btn-primary btn-like">Cancelar</button></a>
            </form>
        </div>
    </div>
</div>

<script src="js/newvoting.js"></script>

<!-- Pie de página -->
<?php
require_once("./layout/footer.php");
?>