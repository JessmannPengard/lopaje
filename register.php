<?php

require("./models/db.php");
require("./models/usuario.php");

$msg = "";
if (isset($_POST["user"])) {
    $usuario = $_POST["user"];
    $password = $_POST["password"];

    $db = new Database;
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Styles -->
    
    <!-- Script -->
    <script src="js/register.js"></script>
    <!-- Page title -->
    <title>Jessmann</title>
    <!-- Favicon -->
    
</head>

<body>

    <!-- Header -->
    <header>
        <nav class="nav nav-fill fixed-top nav-h align-items-center">
            <!-- Logo -->
            <div class="nav-link">
                <a href="index.php"><img src="" alt="" srcset="" class="logo"></a>
            </div>
        </nav>
    </header>

    <!-- Content -->
    <div class="container">
        <div class="row">
            <!-- Main content -->
            <section class="content">
                <h1 class="form-title">Crear cuenta</h1>
                <form action="" method="post" class="login-form" id="registerForm">
                    <div class="mb-3">
                        <label for="user" class="form-label">Nombre de usuario</label>
                        <input type="text" name="user" class="form-control" required placeholder="Nombre de usuario" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label for="c_password" class="form-label">Repetir password</label>
                        <input type="password" name="c_password" id="c-password" class="form-control" required placeholder="Repetir password">
                    </div>
                    <!-- Error message -->
                    <div class="mb-3">
                        <p class="error-text" id="error"></p>
                    </div>
                    <div class="mb-3">
                        <button type="submit" value="Login" class="btn btn-primary">Registrar</button>
                    </div>
                    <div class="mb-3">
                        <span class="form-text">¿Ya estás registrad@?</span><a href="login.php" class="form-link">Inicia sesión</a>
                    </div>
                </form>
            </section>
            <!-- /.content -->
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <nav class="nav fixed-bottom nav-b align-items-center">
            <p class="text-white copyright">Copyright &copy;
                <?php echo date("Y"); ?> · LOPAJE · All Rights Reserved
            </p>
        </nav>
    </footer>
</body>

</html>