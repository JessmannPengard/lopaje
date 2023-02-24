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
    
    <!-- Page title -->
    <title>LOPEICH</title>
    <!-- Favicon -->
    
</head>

<body>
    <!-- Header -->
    <header>
        <nav class="nav fixed-top nav-h align-items-center">
            <!-- User menu button -->
            <div class="nav-link left-nav">
                <a class="text-white" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="fa-solid fa-bars fa-xl"></i>
                </a>
            </div>

            <!-- Logo -->
            <div class="nav-link">
                <a href="#"><img src="" alt="" srcset="" class="logo"></a>
            </div>

            <!-- Future right menu -->
            <div class="nav-link">

            </div>

            <!-- User menu -->
            <div class="offcanvas offcanvas-start offcanvas-size-sm" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
                <?php
                if (isset($_SESSION["user_name"])) {
                    echo "<div class='offcanvas-header'>
                            <h5 class='offcanvas-title' id='offcanvasWithBothOptionsLabel'>" . $_SESSION["user_name"] . "</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
                        </div>
                        <div class='offcanvas-body'>
                            <a class='btn btn-primary' href='mypictures.php' role='button'><i class='fa-solid fa-gear'></i>  Mis imágenes</a>
                            <a class='btn btn-primary' href='logout.php' role='button'><i class='fa-solid fa-right-from-bracket'></i>  Logout</a>
                        </div>";
                } else {
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

    <!-- Content -->
    <div class="container">
        <!-- Sign in message -->
        <?php
        if (!isset($_SESSION["user_name"])) {
            echo "
                    <p class='login-message'>
                        <a href='login.php' class='a-session'>Accede</a> o 
                        <a href='register.php' class='a-session'>Regístrate</a> para poder votar o subir tus imágenes.
                    </p>";
        }
        ?>
        <div class="row">

            <!--Contenido-->
            
        </div>
    </div>

    <footer>
        <nav class="nav fixed-bottom nav-b align-items-center">
            <p class="text-white copyright">Copyright &copy;
                <?php echo date("Y"); ?> · LOPAJE · All Rights Reserved
            </p>
        </nav>
    </footer>

</body>

</html>