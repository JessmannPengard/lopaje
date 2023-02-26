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
                <h2>Galería</h2>
                <!-- Opciones para ordenar la galería -->
                <div class="orderby">
                    <span><a href="index.php?orderby=fecha&dir=<?php echo $op_dir ?>"
                            class="<?php echo $orden == "fecha" ? "filter-active" : ""; ?>">Recientes</a></span><i
                        class="<?php echo $dir == "asc" && $orden == "fecha" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
                    <span><a href="index.php?orderby=num_votos&dir=<?php echo $op_dir ?>"
                            class="<?php echo $orden == "num_votos" ? "filter-active" : ""; ?>">Votos</a></span><i
                        class="<?php echo $dir == "asc" && $orden == "num_votos" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
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

                $db = new Database();
                $imagen = new Imagen($db->getConnection());
                $usuario = new User($db->getConnection());
                $voto = new Voto($db->getConnection());
                // Obtenemos un array con todas las imágenes
                $imagenes = $imagen->getAll($orden, $dir);
                // Recorremos el array y vamos llenando la galería
                foreach ($imagenes as $key => $value) {
                    // Obtenemos el nombre se usuario que subió la imagen
                    $nombre_usuario = $usuario->getUsername($value["id_usuario"]);
                    // Finalmente mostramos la imagen, nombre de usuario que la subió y número de votos que tiene
                    echo '<div class="col-md-6 col-lg-4">
                            <div class="card my-3">
                                <div class="image-container">
                                    <img src="' . $value["url_imagen"] . '"
                                        class="card-img-top" alt="thumbnail">
                                    <div class="image-overlay"></div>
                                </div>
                                    <p class="author">' . $nombre_usuario . '</p>
                                <div class="card-body">
                                    <p><i class="fa-solid fa-heart like"></i> ' . $value["num_votos"] . '</p>';
                    // Además, si el usuario está logueado mostraremos el botón de votar.
                    // En el botón de votar llamaremos a la función votar() que se encuentra en votar.js, debemos pasarle 3 parámetros:
                    // un id de imagen, un id de usuario y verdadero(votar) o falso(eliminar voto)
                    if (isset($_SESSION["username"])) {
                        // Comprobamos si el usuario que está logueado ya ha votado esta imagen
                        $votada = $voto->checkVote($value["id"], $usuario->getId($_SESSION["username"]));
                        // Si ya la ha votado le pondremos la clase "btn-like" al botón para cambiar su estilo visual
                        $clase_boton = $votada ? "btn-like" : "";
                        // Establecemos el contenido del botón en función de si ya la ha votado o no
                        $contenido_boton = $votada ? "<i class='fa-solid fa-heart'></i>" : "Votar";
                        // Y mostramos el botón
                        echo '<button onclick="votar(' . $value["id"] . ',' . $usuario->getId($_SESSION["username"]) . ',' . !$votada . ')" class="btn btn-primary ' . $clase_boton . '">
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