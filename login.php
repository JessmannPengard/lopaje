<?php

require("./models/db.php");
require("./models/usuario.php");

$msg = "";
if (isset($_POST["user"])) {
    $usuario = $_POST["user"];
    $password = $_POST["password"];

    $db = new Database();
    $user = new User($db->getConnection());

    if ($user->login($usuario, $password)) {
        // Login correcto
        session_start();
        $_SESSION["username"] = $usuario;
        header("Location: index.php");
    } else {
        //Login incorrecto
        $msg = "Usuario y/o contraseña incorrectos.";
    }
}

?>

<!--Header-->
<?php
require_once("./layout/header.php");
?>

<!-- Content -->
<div class="container">
    <div class="row">
        <!-- Main content -->
        <section class="content">
            <h1 class="form-title">Inicia sesión</h1>
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
                <!-- Error message -->
                <div class="mb-3">
                    <p class='error-text'>
                        <?php echo $msg; ?>
                    </p>
                </div>
                <div class="mb-3">
                    <button type="submit" value="Login" class="btn btn-primary">Login</button>
                </div>
                <div class="mb-3">
                    <span class="form-text">¿No tienes una cuenta? </span><a href="register.php"
                        class="form-link"> Regístrate aquí</a>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
</div>

<!--Footer-->
<?php
require_once("./layout/footer.php");
?>