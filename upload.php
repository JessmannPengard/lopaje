<?php

require_once("./models/db.php");
require_once("./models/usuario.php");
require_once("./models/imagen.php");

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

$directorio_subida = 'upload/';
$msg = "";
if (isset($_POST["file"])) {
    // verificar si se subió un archivo y si no hay errores
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // verificar el tipo de archivo
        $tipos_permitidos = array('image/jpeg', 'image/png');
        if (in_array($_FILES['imagen']['type'], $tipos_permitidos)) {
            // verificar el tamaño del archivo
            $tamano_maximo = 5 * 1024 * 1024; // 5MB
            if ($_FILES['imagen']['size'] <= $tamano_maximo) {
                // renombrar el archivo para evitar sobrescribir archivos existentes
                $nombre_archivo = uniqid('imagen_', true) . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                // mover el archivo a la carpeta de destino con el nuevo nombre de archivo
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio_subida . $nombre_archivo)) {
                    // El archivo se subió correctamente
                    $db = new Database();
                    $usuario = new User($db->getConnection());
                    $imagen = new Imagen($db->getConnection());
                    $imagen->upload($usuario->getId($_SESSION["username"]), $directorio_subida . $nombre_archivo);
                    header("Location: index.php");
                } else {
                    $msg = "Hubo un error al mover el archivo";
                }
            } else {
                $msg = "El archivo es demasiado grande (tamaño máximo permitido: " . $tamano_maximo / 1024 / 1024 . "MB)";
            }
        } else {
            $msg = "El tipo de archivo no está permitido";
        }
    } else {
        $msg = "Hubo un error al subir el archivo";
    }
}
?>

<!--Header-->
<?php
require_once("./layout/header.php");
?>

<section class="bg-light">
    <div class="container">
        <h2>Sube tu imagen</h2>
        <p>PNG o JPEG, tamaño máximo permitido: 5MB</p>
        <form id="formulario" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="imagen">Seleccionar imagen:</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/png, image/jpeg">
            </div>
            <div class="form-group">
                <img id="previsualizacion" src="#" alt="Previsualización de la imagen"
                    style="max-width: 100%; height: auto;">
            </div>
            <!-- Error message -->
            <div class="mb-3">
                <p class='error-text'>
                    <?php echo $msg; ?>
                </p>
            </div>
            <button type="submit" name="file" class="btn btn-primary">Subir imagen</button>
        </form>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        // cuando se cambia el valor del campo de imagen, actualizar la previsualización
        $('#imagen').on('change', function () {
            var archivo = $(this)[0].files[0];
            if (archivo) {
                var lector = new FileReader();
                lector.onload = function (e) {
                    $('#previsualizacion').attr('src', e.target.result);
                }
                lector.readAsDataURL(archivo);
            }
        });
    });
</script>

<!--Footer-->
<?php
require_once("./layout/footer.php");
?>