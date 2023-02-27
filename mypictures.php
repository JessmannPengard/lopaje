<?php
// Iniciamos sesión
session_start();

// Establecer el orden en el que se muestran las imágenes (por defecto 'fecha ASC')
$orden = isset($_GET["orderby"]) && ($_GET["orderby"] == "fecha" || $_GET["orderby"] == "num_votos") ? $_GET["orderby"] : "fecha";
$dir = isset($_GET["dir"]) && ($_GET["dir"] == "asc" || $_GET["dir"] == "desc") ? $_GET["dir"] : "asc";
$op_dir = $dir == "asc" ? "desc" : "asc";
?>

<!-- Incluimos la cabecera -->
<?php
require_once("./layout/header.php");
?>

<!-- Contenido -->
<div class="container">
    <!-- Mensaje que se muestra cuando no hay un usuario logueado -->
    <?php
    if (!isset($_SESSION["username"])) {
        echo "
                    <p class='login-message'>
                        <a href='login.php' class='a-session'>Accede</a> o 
                        <a href='register.php' class='a-session'>Regístrate</a> para poder votar o subir tus imágenes.
                    </p>";
    }
    ?>

    <!-- Galería -->
    <section class="bg-light">
        <div class="container">
            <div class="head-gallery">
                <!-- Título de la galería -->
                <h2>Mis Fotos</h2>
                <!-- Opciones para ordenar la galería -->
                <div class="orderby">
                    <span><a href="mypictures.php?orderby=fecha&dir=<?php echo $op_dir ?>" class="<?php echo $orden == "fecha" ? "filter-active" : ""; ?>">Recientes</a></span><i class="<?php echo $dir == "asc" && $orden == "fecha" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
                    <span><a href="mypictures.php?orderby=num_votos&dir=<?php echo $op_dir ?>" class="<?php echo $orden == "num_votos" ? "filter-active" : ""; ?>">Votos</a></span><i class="<?php echo $dir == "asc" && $orden == "num_votos" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
                </div>
            </div>
            <!-- Parte donde se muestran las imágenes -->
            <div class="row galeria">
                <?php
                // Traemos los modelos necesarios
                require_once("./models/db.php");
                require_once("./models/imagen.php");
                require_once("./models/votos.php");
                require_once("./models/usuario.php");
                require_once("./utils/dates.php");

                $db = new Database();




                $imagen = new Imagen($db->getConnection());
                $usuario = new User($db->getConnection());
                $voto = new Voto($db->getConnection());
                $id_user = $usuario->getId($_SESSION["username"]);
                // Obtenemos un array con todas las imágenes
                $imagenes = $imagen->getById_User($id_user, $orden, $dir);
                // Recorremos el array y vamos llenando la galería
                foreach ($imagenes as $key => $value) {
                    // Obtenemos el nombre se usuario que subió la imagen
                    $nombre_usuario = $usuario->getUsername($value["id_usuario"]);
                    // Formateamos el intervalo de tiempo a mostrar (desde la fecha de publicación hasta ahora)
                    $fechaPublicacion = new DateTime($value["fecha"]);
                    $fechaActual = new DateTime("now");
                    $fecha = format_interval_dates_short($fechaActual, $fechaPublicacion);
                    // Finalmente mostramos la imagen, nombre de usuario que la subió y número de votos que tiene
                    echo '<div class="col-md-6 col-lg-4">
                            <div class="card my-3">
                                <div class="image-container">
                                    <img src="' . $value["url_imagen"] . '"
                                        class="card-img-top" alt="thumbnail">
                                    <div class="image-overlay"></div>
                                </div>
                                    <div class="card-body">
                                        <div>
                                            <i class="fa-solid fa-heart like"></i>
                                            <span class="num-votos">' . $value["num_votos"] . '</span>
                                        </div>
                                        <span class="fecha">· subida hace ' . $fecha . '</span>
                                    </div>
                            </div>
                        </div>';
                }
                ?>

            </div>
        </div>
    </section>

    <!-- Botón para subir imágenes, sólo se muestra si hay un usuario logueado -->
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

<!-- Script para la galería -->
<script src="js/index.js"></script>

<!-- Pie de página -->
<?php
require_once("./layout/footer.php");
?>