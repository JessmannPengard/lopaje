<!-- Encabezado de página -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <!-- Mis scripts -->
    <script src="js/header.js"></script>
    <script src="js/votar.js"></script>
    <!-- Estilos -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Título de la página -->
    <title>LOPEICH</title>
    <!-- Favicon -->

</head>

<body class="bg-light">
    <!-- Header -->
    <header>
        <nav class="nav fixed-top nav-h align-items-center" id="header">
            <!-- Botón del menú de usuario -->
            <!-- Muestra el offcanvas -->
            <div class="nav-link left-nav">
                <a class="menu" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                    aria-controls="offcanvasWithBothOptions">
                    <i class="fa-solid fa-bars fa-xl"></i>
                </a>
            </div>

            <!-- Logo -->
            <div class="nav-link">
                <a href="index.php"><img src="img/logo.jpeg" alt="" srcset="" class="logo"></a>
            </div>

            <!-- Nombre del usuario si está logueado -->
            <div class="nav-link right-nav">
                <?php
                if (isset($_SESSION["username"])) {
                    echo '<i class="fa-solid fa-user user-icon"></i><a href="mypictures.php">' . $_SESSION["username"] . '</a>';
                }
                ?>
            </div>

            <!-- Menú de usuario (offcanvas), se muestra al pulsar el botón de menú -->
            <div class="offcanvas offcanvas-start offcanvas-size-sm" data-bs-scroll="true" tabindex="-1"
                id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                <?php
                if (isset($_SESSION["username"])) {
                    // Menú si está logueado
                    echo "<div class='offcanvas-header'>
                            <h5 class='offcanvas-title' id='offcanvasWithBothOptionsLabel'>" . $_SESSION["username"] . "</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
                        </div>
                        <div class='offcanvas-body'>
                            <a class='btn btn-primary' href='mypictures.php' role='button'><i class='fa-solid fa-images'></i>  Mis imágenes</a>
                            <a class='btn btn-primary' href='myvotings.php' role='button'><i class='fa-solid fa-square-poll-vertical'></i>  Mis votaciones</a>
                            <a class='btn btn-primary' href='logout.php' role='button'><i class='fa-solid fa-right-from-bracket'></i>  Logout</a>
                        </div>";
                } else {
                    // Menú si no está logueado
                    echo "<div class='offcanvas-header'>
                            <h5 class='offcanvas-title' id='offcanvasWithBothOptionsLabel'>Opciones de usuario</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
                        </div>
                        <div class='offcanvas-body'>
                            <a class='btn btn-primary' href='login.php' role='button'>Login</a>
                            <a class='btn btn-primary' href='register.php' role='button'>Registro</a>
                        </div>";
                }
                ?>
            </div>
        </nav>
    </header>