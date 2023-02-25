<?php
session_start();
if (isset($_SESSION["username"])) {
    //var_dump("Sesión activa: " . $_SESSION["username"]);
}
?>

<!--Header-->
<?php
require_once("./layout/header.php");
?>

<!-- Content -->
<div class="container">
    <!-- Sign in message -->
    <?php
    if (!isset($_SESSION["username"])) {
        echo "
                    <p class='login-message'>
                        <a href='login.php' class='a-session'>Accede</a> o 
                        <a href='register.php' class='a-session'>Regístrate</a> para poder votar o subir tus imágenes.
                    </p>";
    }
    ?>


    <!--Contenido-->
    <section class="bg-light">
        <div class="container">
            <div class="head-gallery">
                <h2>Galería</h2>
                <div class="orderby">
                    <span class="filter-active">Recientes</span><i class="fa-solid fa-arrow-up"></i><i class="fa-solid fa-arrow-down filter-active"></i>
                    <span>Votos</span><i class="fa-solid fa-arrow-up"></i><i class="fa-solid fa-arrow-down"></i>
                </div>
            </div>
            <div class="row">

                <?php
                require_once("./models/db.php");
                require_once("./models/imagen.php");
                require_once("./models/votos.php");
                require_once("./models/usuario.php");

                $db = new Database();
                $imagen = new Imagen($db->getConnection());
                $voto = new Voto($db->getConnection());
                $usuario = new User($db->getConnection());
                $imagenes = $imagen->getAll();
                foreach ($imagenes as $key => $value) {
                    $votos = count($voto->getById_Image($value["id"]));
                    $nombre_usuario = $usuario->getUsername($value["id_usuario"]);

                    echo '<div class="col-md-6 col-lg-4">
                            <div class="card my-3">
                                <img src="' . $value["url_imagen"] . '"
                                    class="card-img-top" alt="thumbnail">
                                    <p class="author">' . $nombre_usuario . '</p>
                                <div class="card-body">
                                    <p><i class="fa-solid fa-heart like"></i> ' . $votos . '</p><a href="#" class="btn btn-primary">Votar</a>
                                </div>
                            </div>
                        </div>';
                }
                ?>

            </div>
        </div>
    </section>

    <!-- New post button -->
    <?php
    if (isset($_SESSION["username"])) {
        echo "<div class='fab-container'>
            <div class='button iconbutton'>
              <a href='upload.php'><i class='fa-solid fa-upload'></i></a>
            </div>
          </div";
    }
    ?>

</div>

</div>

<!--Footer-->
<?php
require_once("./layout/footer.php");
?>