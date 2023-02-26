window.onload = function () {
    // Al cargar la página nos situamos arriba de todo
    window.scrollTo(0, 0);
}

// Función para emitir y borrar los votos llamando a votar.php
// y pasándole los parámetros necesarios
function votar(id_imagen, id_usuario, valor = true) {

    // Definimos los parámetros que pasaremos a votar.php
    const parametros = new URLSearchParams();
    parametros.append('id_imagen', id_imagen);
    parametros.append('id_usuario', id_usuario);
    parametros.append('valor', valor);

    // Llamar al archivo PHP con los parámetros GET usando fetch()
    fetch('votar.php?' + parametros)
        .then(response => response.text())
        .then(data => window.location.reload(true)) // Recargamos la página para acualizar los datos
        .catch(error => console.error(error));

}