<?php
// Importamos los modelos necesarios
require_once("./models/db.php");
require_once("./models/usuario.php");
require_once("./models/imagen.php");

// Iniciamos sesión y comprobamos si el usuario está logueado, en caso contrario lo redirigimos al index.php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

// Establecemos la ruta en la que guardamos las imágenes subidas por los usuarios
$directorio_subida = 'upload/';

// Inicializamos la variable que guardará el mensaje en caso de posibles errores
$msg = "";

// Si nos han enviado una imagen:
if (isset($_POST["file"])) {
    // Verificamos si se subió un archivo y si no hay errores
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Verificamos el tipo de archivo (aquí establecemos los tipos de archivos permitidos)
        $tipos_permitidos = array('image/jpeg', 'image/png');
        if (in_array($_FILES['imagen']['type'], $tipos_permitidos)) {
            // Verificamos el tamaño del archivo, aquí establecemos el tamaño máximo de archivo permitido
            $tamano_maximo = 5 * 1024 * 1024; // 5MB
            if ($_FILES['imagen']['size'] <= $tamano_maximo) {
                // Renombramos el archivo para evitar sobrescribir archivos existentes mediante la función uniqid
                $nombre_archivo = uniqid('imagen_', true) . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                // Movemos el archivo a la carpeta de destino que hemos designado ($directorio_subida) con el nuevo nombre de archivo
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio_subida . $nombre_archivo)) {
                    // El archivo se subió correctamente
                    // Guardamos en la base de datos la información de la imagen
                    // Creamos la conexión
                    $db = new Database();
                    // Obtenemos los id's de usuario e imagen
                    $usuario = new User($db->getConnection());
                    $imagen = new Imagen($db->getConnection());
                    // Y los guardamos en la base de datos junto con la ruta del archivo que se acaba de subir
                    $imagen->upload($usuario->getId($_SESSION["username"]), $directorio_subida . $nombre_archivo);
                    // Finalmente redirigimos al index.php
                    header("Location: index.php");
                } else {
                    // Error al mover el archivo
                    $msg = "Hubo un error al mover el archivo";
                }
            } else {
                // Archivo demasiado grande
                $msg = "El archivo es demasiado grande (tamaño máximo permitido: " . $tamano_maximo / 1024 / 1024 . "MB)";
            }
        } else {
            // Tipo de archivo no permitido
            $msg = "El tipo de archivo no está permitido";
        }
    } else {
        // Error al subir el archivo
        $msg = "Hubo un error al subir el archivo";
    }
}
?>

<!-- Cabecera de página -->
<?php
require_once("./layout/header.php");
?>

<!-- Contenido -->
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
            <!-- Mensaje de error si lo hubiese -->
            <div class="mb-3">
                <p class='error-text'>
                    <?php echo $msg; ?>
                </p>
            </div>
            <button type="submit" name="file" class="btn btn-primary">Subir imagen</button>
        </form>
    </div>
</section>

<!-- Script para previsualizar las imágenes -->
<script src="js/upload.js"></script>

<!-- Pie de página -->
<?php
require_once("./layout/footer.php");
?>