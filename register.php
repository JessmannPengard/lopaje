<?php

require("./models/db.php");
require("./models/usuario.php");

$msg = "";
if (isset($_POST["user"])) {
    $usuario = $_POST["user"];
    $password = $_POST["password"];

    $db = new Database();
    $user = new User($db->getConnection());

    $registro = $user->register($usuario, $password);
    if ($registro["result"]) {
        // Registro correcto
        header("Location: login.php");
    } else {
        //Login incorrecto
        $msg = $registro["msg"];
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
            <h1 class="form-title">Crear cuenta</h1>
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
                <!-- Error message -->
                <div class="mb-3">
                    <p class="error-text" id="error"></p>
                </div>
                <div class="mb-3">
                    <button type="submit" value="Login" class="btn btn-primary">Registrar</button>
                </div>
                <div class="mb-3">
                    <span class="form-text">¿Ya estás registrad@?</span><a href="login.php" class="form-link"> Inicia
                        sesión</a>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
</div>

<script src="js/register.js"></script>

<!--Footer-->
<?php
require_once("./layout/footer.php");
?>