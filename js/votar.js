// Función para emitir y borrar los votos llamando a votar.php
// y pasándole los parámetros necesarios
function votar(event, id_imagen, id_usuario, valor) {

    // Definimos los parámetros que pasaremos a votar.php
    const parametros = new URLSearchParams();
    parametros.append('id_imagen', id_imagen);
    parametros.append('id_usuario', id_usuario);
    parametros.append('valor', valor);

    // Llamamos al archivo PHP con los parámetros GET para emitir o eliminar el voto
    fetch('votar.php?' + parametros)
        .then(response => response.text())
        .then(data => {

            if (data == "OK") {
                // Obtenemos la referencia al botón pulsado
                // y al contador de votos
                var boton = event.target;
                var div = boton.parentNode;
                var span = div.querySelector(".num-votos");

                if (valor == true) {
                    // Si ha votado le pondremos la clase "btn-like" al botón 
                    // para cambiar su estilo visual y el texto
                    boton.classList.add('btn-like');
                    boton.innerText = "Votada!";
                    // Incrementamos el contador de votos
                    span.textContent++;
                } else {
                    // En caso contrario hacemos lo propio
                    boton.classList.remove('btn-like');
                    boton.innerText = "Votar";
                    // Decrementamos el contador de votos
                    span.textContent--;
                }
                // Cambiar la propiedad onclick del botón
                var nuevoValor = valor == 1 ? 0 : 1;
                boton.onclick = function () {
                    votar(event, id_imagen, id_usuario, nuevoValor);
                };
            } else {
                // La votación ha finalizado, así que recargamos la página
                // sin permitir al usuario hacer cambios
                location.reload();
            }
        })
        .catch(error => console.error(error));

}