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

    // Y llamamos al método login para iniciar sesión
    if ($user->login($usuario, $password)) {
        // Login correcto, iniciamos sesión
        session_start();
        // Guardamos la variable de sesión username
        // que utilizaremos posteriormente para comprobar que haya un usuario logueado
        $_SESSION["username"] = $usuario;
        // Finalmente redirigimos al index.php (página principal)
        header("Location: index.php");
    } else {
        // Login incorrecto, guardamos el mensaje de error a mostrar más abajo
        $msg = "Usuario y/o contraseña incorrectos.";
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
            <h1 class="form-title">Inicia sesión</h1>
            <!-- Formulario de inicio de sesión -->
            <form action="" method="post" class="login-form">
                <div class="mb-3">
                    <label for="user" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" name="user" placeholder="Nombre de usuario" required
                        autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <!-- Mostramos el mensaje de error, si lo hubiera, si no estaría vacío "" -->
                <div class="mb-3">
                    <p class='error-text'>
                        <?php echo $msg; ?>
                    </p>
                </div>
                <div class="mb-3">
                    <button type="submit" value="Login" class="btn btn-primary">Login</button>
                </div>
                <!-- Enlace a la página de registro -->
                <div class="mb-3">
                    <span class="form-text">¿No tienes una cuenta? </span><a href="register.php" class="form-link">
                        Regístrate aquí</a>
                </div>
            </form>
        </section>
    </div>
</div>

<!--Footer-->
<?php
require_once("./layout/footer.php");
?>