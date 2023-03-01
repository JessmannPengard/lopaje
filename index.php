<?php

// Iniciamos sesión
session_start();

// Establecer el orden en el que se muestran las votaciones (por defecto 'fecha_creacion DESC' y se muestran también las finalizadas)
$orden = isset($_GET["orderby"]) && ($_GET["orderby"] == "fecha_creacion" || $_GET["orderby"] == "fecha_fin") ? $_GET["orderby"] : "fecha_creacion";
$dir = isset($_GET["dir"]) && ($_GET["dir"] == "asc" || $_GET["dir"] == "desc") ? $_GET["dir"] : "desc";
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
                        <a href='register.php' class='a-session'>Regístrate</a> para poder crear nuevas votaciones, votar o subir tus imágenes.
                    </p>";
    }
    ?>

    <!-- Votaciones -->
    <section class="bg-light">
        <div class="container">
            <div class="head-gallery">
                <!-- Título del apartado de votaciones -->
                <h2>Votaciones</h2>
                <!-- Opciones para ordenar las votaciones -->
                <div class="orderby">
                    <span>
                        <a href="index.php?orderby=fecha_creacion&dir=<?php echo $op_dir ?>"
                            class="<?php echo $orden == "fecha_creacion" ? "filter-active" : ""; ?>">Recientes</a>
                    </span>
                    <i
                        class="<?php echo $dir == "asc" && $orden == "fecha_creacion" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
                    <span>
                        <a href="index.php?orderby=fecha_fin&dir=<?php echo $op_dir ?>"
                            class="<?php echo $orden == "fecha_fin" ? "filter-active" : ""; ?>">Finalización</a>
                    </span>
                    <i
                        class="<?php echo $dir == "asc" && $orden == "fecha_fin" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
                </div>
            </div>
            <!-- Parte donde se muestran las votaciones -->
            <div class="row galeria">
                <?php
                // Traemos los modelos necesarios
                require_once("./models/db.php");
                require_once("./models/votacion.php");
                require_once("./models/usuario.php");
                require_once("./utils/dates.php");

                $db = new Database();
                $usuario = new User($db->getConnection());
                $votacion = new Votacion($db->getConnection());
                // Obtenemos un array con todas las votaciones
                $votaciones = $votacion->getAll($orden, $dir);
                // Recorremos el array y vamos llenando el contenido
                foreach ($votaciones as $key => $value) {
                    // Obtenemos el nombre se usuario que creó la votación
                    $nombre_usuario = $usuario->getUsername($value["id_usuario"]);
                    // Formateamos el intervalo de tiempo a mostrar (desde la fecha de publicación hasta ahora)
                    $fechaPublicacion = new DateTime($value["fecha_creacion"]);
                    $fechaActual = new DateTime("now");
                    $fechaFin = new DateTime($value["fecha_fin"]);
                    $creadaHace = format_interval_dates_short($fechaActual, $fechaPublicacion);
                    $finalizaEn = format_interval_dates_short($fechaFin, $fechaActual);
                    $diferencia = $fechaActual->diff($fechaFin);
                    // Comprobamos si la votación ya ha finalizado
                    if ($diferencia->invert != 0) {
                        $finalizada = true;
                        $txt = "Finalizada";
                        $borde = "border-danger";
                        $color="filter-active";
                    } else {
                        $finalizada = false;
                        $txt = "finaliza en " . $finalizaEn;
                        $borde = "border-success";
                        $color="";
                    }
                    // Finalmente mostramos la votación, nombre de usuario que la creó y resto de información

                    echo '  <div class="col-md-6 col-lg-4">
                                <div class="card my-3 ' . $borde . '">
                                    <div>
                                        <img src="' . $value["url"] . '" alt="" class="card-img-top">
                                        <div class="texto-encima">
                                            <h5 class="card-title">' . $value["titulo"] . '</h5>
                                        </div>
                                        <div class="contenedor-inferior">';
                                    // Ponemos el botón en función de si ha finalizado o no
                                    if ($finalizada) {
                                        echo '  <div class="card-body d-flex justify-content-center">
                                                    <a href="galeria.php?votacion=' . $value["id"] . '" class="btn btn-primary btn-like">Ver resultados</a>
                                                </div>';
                                    } else {
                                        echo '  <div class="card-body d-flex justify-content-center">
                                                    <a href="galeria.php?votacion=' . $value["id"] . '" class="btn btn-primary">Participa</a>
                                                </div>';
                                    }
                                        echo'   <div class="texto-inferior">
                                                    <span class="fecha">creada hace ' . $creadaHace . '</span>
                                                    <span>' . $nombre_usuario . '</span>
                                                    <span class="fecha ' . $color . '">' . $txt . '</span>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }
                ?>

            </div>
        </div>
    </section>

    <!-- Botón para crear votaciones, sólo se muestra si hay un usuario logueado -->
    <?php
    if (isset($_SESSION["username"])) {
        echo "<div class='fab-container'>
            <div class='button iconbutton'>
              <a href='newvoting.php'><i class='fa-solid fa-plus'></i></a>
            </div>
          </div";
    }
    ?>

</div>

</div>

<!-- Pie de página -->
<?php
require_once("./layout/footer.php");
?>