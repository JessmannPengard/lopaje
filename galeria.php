<?php
// Iniciamos sesión
session_start();

// Si se ha pasado el parámetro votación
// guardamos el valor para usarlo después
// en la consulta y resto de operaciones
if (isset($_GET["votacion"])) {
    $votacion = $_GET["votacion"];
} else {
    // En caso contrario redirigimos a la página de inicio
    header("Location: index.php");
}

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

    // Traemos los modelos necesarios
    require_once("./models/db.php");
    require_once("./models/votacion.php");
    require_once("./models/usuario.php");

    // Conectamos con la base de datos
    $db = new Database();

    // Obtenemos lod datos de la votación seleccionada
    $v = new Votacion($db->getConnection());
    $votacionActual = $v->getById($votacion);
    $titulo = $votacionActual["titulo"];
    $descripcion = $votacionActual["descripcion"];
    $u = new User($db->getConnection());
    $creador = $u->getUsername($votacionActual["id_usuario"]);

    // Comprobamos si la votación ya ha finalizado
    $fechaActual = new DateTime("now");
    $fechaFin = new DateTime($votacionActual["fecha_fin"]);
    $diferencia = $fechaActual->diff($fechaFin);
    // Comprobamos si la votación ya ha finalizado
    if ($diferencia->invert != 0) {
        $finalizada = true;
    } else {
        $finalizada = false;
    }

    ?>

    <!-- Galería -->
    <section class="bg-light">
        <div class="container">
            <div class="head-gallery">
                <div class="head-gallery-left">
                    <!-- Título de la galería -->
                    <h2>
                        <?php echo $titulo ?>
                    </h2>
                    <!-- Descripción de la galería -->
                    <p>
                        <?php echo $descripcion ?>
                    </p>
                    <span class="fecha">
                        creada por <?php echo $creador ?>
                    </span>
                </div>
                <!-- Opciones para ordenar la galería -->
                <div class="orderby">
                    <span><a href="galeria.php?votacion=<?php echo $votacion ?>&orderby=fecha&dir=<?php echo $op_dir ?>" class="<?php echo $orden == "fecha" ? "filter-active" : ""; ?>">Recientes</a></span><i class="<?php echo $dir == "asc" && $orden == "fecha" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
                    <span><a href="galeria.php?votacion=<?php echo $votacion ?>&orderby=num_votos&dir=<?php echo $op_dir ?>" class="<?php echo $orden == "num_votos" ? "filter-active" : ""; ?>">Votos</a></span><i class="<?php echo $dir == "asc" && $orden == "num_votos" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
                </div>
            </div>
            <!-- Parte donde se muestran las imágenes -->
            <div class="row galeria">
                <?php
                // Traemos los modelos necesarios

                require_once("./models/imagen.php");
                require_once("./models/votos.php");
                require_once("./utils/dates.php");

                $imagen = new Imagen($db->getConnection());
                $usuario = new User($db->getConnection());
                $voto = new Voto($db->getConnection());
                // Obtenemos un array con todas las imágenes
                $imagenes = $imagen->getAllbyIdVotacion($votacion, $orden, $dir);
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
                                    <p class="author">' . $nombre_usuario . '<span class="fecha">· subida hace ' . $fecha . '</span></p>
                                <div class="card-body">
                                    <p><i class="fa-solid fa-heart like"></i><span class="num-votos">' . $value["num_votos"] . '</span></p>';
                    // Además, si el usuario está logueado mostraremos el botón de votar (sólo en el caso de que la votación no haya finalizado ya).
                    // En el botón de votar llamaremos a la función votar() que se encuentra en votar.js, debemos pasarle 3 parámetros:
                    // un id de imagen, un id de usuario y verdadero(votar) o falso(eliminar voto)
                    if (isset($_SESSION["username"]) && !$finalizada) {
                        // Comprobamos si el usuario que está logueado ya ha votado esta imagen
                        $votada = $voto->checkVote($value["id"], $usuario->getId($_SESSION["username"])) ? 1 : 0;
                        $pr = $votada == 1 ? 0 : 1;
                        // Si ya la ha votado le pondremos la clase "btn-like" al botón para cambiar su estilo visual
                        $clase_boton = $votada ? "btn-like" : "";
                        // Establecemos el contenido del botón en función de si ya la ha votado o no
                        $contenido_boton = $votada ? "Votada!" : "Votar";
                        // Mostramos el botón y le asociamos la función de votar de votar.js
                        echo '<button onclick="votar(event, ' . $value["id"] . ',' . $usuario->getId($_SESSION["username"]) . ',' . $pr . ')" class="btn btn-primary ' . $clase_boton . '">
                                        ' . $contenido_boton . '
                                    </button>';
                    }
                    echo '      </div>
                            </div>
                        </div>';
                }
                ?>

            </div>
        </div>
    </section>

    <!-- Botón para subir imágenes, sólo se muestra si hay un usuario logueado y la votación no ha finalizado-->
    <?php
    if (isset($_SESSION["username"]) && !$finalizada) {
        echo "<div class='fab-container'>
            <div class='button iconbutton'>
              <a href='upload.php?votacion=" . $votacion . "'><i class='fa-solid fa-upload'></i></a>
            </div>
          </div";
    }
    ?>

</div>

</div>

<!-- Script para la galería -->
<script src="js/galeria.js"></script>

<!-- Pie de página -->
<?php
require_once("./layout/footer.php");
?>