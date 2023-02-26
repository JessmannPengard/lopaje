<?php

// Importamos los modelos necesarios
require("./models/db.php");
require("./models/usuario.php");

// Inicializamos la variable que usaremos para mostrar mensajes en caso de algún error
$msg = "";

// Si nos están enviando el formulario...
if (isset($_POST["user"])) {
    // Obtenemos el nombre de usuario y contraseña
    $usuario = $_POST["user"];
    $password = $_POST["password"];

    // Nos conectamos a la base de datos
    $db = new Database();
    $user = new User($db->getConnection());

    // Y llamamos al método register para registrar un nuevo usuario
    $registro = $user->register($usuario, $password);
    // Si el resultado es positivo
    if ($registro["result"]) {
        // Registro correcto, redirigimos a la página de login para que el usuario pueda iniciar sesión
        header("Location: login.php");
    } else {
        // Registro no realizado, guardamos el mensaje de error a mostrar más abajo
        $msg = $registro["msg"];
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
        <section class="content">
            <!-- Título del formulario -->
            <h1 class="form-title">Crear cuenta</h1>
            <!-- Formulario de registro -->
            <form action="" method="post" class="login-form" id="registerForm">
                <div class="mb-3">
                    <label for="user" class="form-label">Nombre de usuario</label>
                    <input type="text" name="user" class="form-control" required placeholder="Nombre de usuario"
                        autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required
                        placeholder="Password">
                </div>
                <div class="mb-3">
                    <label for="c_password" class="form-label">Repetir password</label>
                    <input type="password" name="c_password" id="c-password" class="form-control" required
                        placeholder="Repetir password">
                </div>
                <!-- Mostramos el mensaje de error, si lo hubiera, si no estaría vacío "" -->
                <div class="mb-3">
                    <p class="error-text" id="error"></p>
                </div>
                <div class="mb-3">
                    <button type="submit" value="Login" class="btn btn-primary">Registrar</button>
                </div>
                <!-- Enlace a la página de inicio de sesión -->
                <div class="mb-3">
                    <span class="form-text">¿Ya estás registrad@?</span><a href="login.php" class="form-link"> Inicia
                        sesión</a>
                </div>
            </form>
        </section>
    </div>
</div>

<!-- Script que comprueba que el cambo Repetir password coincida con el campo Password -->
<script src="js/register.js"></script>

<!-- Pie de página -->
<?php
require_once("./layout/footer.php");
?>