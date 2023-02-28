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
    <!-- Si no está logueado no tiene acceso -->
    <?php
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
    }
    ?>

    <!-- Votaciones creadas -->
    <section class="bg-light">
        <div class="container">
            <div class="head-gallery">
                <!-- Título -->
                <h2>Mis Votaciones</h2>
                <!-- Opciones para ordenar las votaciones -->
                <div class="orderby">
                    <span>
                        <a href="myvotings.php?orderby=fecha_creacion&dir=<?php echo $op_dir ?>" class="<?php echo $orden == "fecha_creacion" ? "filter-active" : ""; ?>">Recientes</a>
                    </span>
                    <i class="<?php echo $dir == "asc" && $orden == "fecha_creacion" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
                    <span>
                        <a href="myvotings.php?orderby=fecha_fin&dir=<?php echo $op_dir ?>" class="<?php echo $orden == "fecha_fin" ? "filter-active" : ""; ?>">Finalización</a>
                    </span>
                    <i class="<?php echo $dir == "asc" && $orden == "fecha_fin" ? "fa-solid fa-arrow-up" : "fa-solid fa-arrow-down"; ?>"></i>
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
                $id_user = $usuario->getId($_SESSION["username"]);
                $votacion = new Votacion($db->getConnection());

                // Obtenemos un array con todas las votaciones
                $votaciones = $votacion->getByIdUser($id_user, $orden, $dir);
                // Recorremos el array y vamos llenando la galería
                foreach ($votaciones as $key => $value) {
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
                        $color = "filter-active";
                    } else {
                        $finalizada = false;
                        $txt = "finaliza en " . $finalizaEn;
                        $borde = "border-success";
                        $color = "";
                    }
                    // Finalmente mostramos la votación
                    echo '<div class="col-md-6 col-lg-4">
                            <div class="card ' . $borde . '">
                                <div class="card-header text-center ' . $color . '">
                                    ' . $txt . '
                                </div>
                                <div class="card-body vote-container">
                                    <h5 class="card-title">' . $value["titulo"] . '</h5>
                                    <p class="card-text">' . $value["descripcion"] . '</p>
                                    <p class="fecha">' . $txt . '</p>
                                    <a href="galeria.php?votacion='.$value["id"].'"><p class="text-center">>></p></a>
                                </div>
                                <div class="card-footer text-muted text-center">
                                    creada hace ' . $creadaHace . '
                                </div>
                            </div>
                        </div>';
                }
                ?>

            </div>
        </div>
    </section>

</div>

</div>


<!-- Pie de página -->
<?php
require_once("./layout/footer.php");
?>