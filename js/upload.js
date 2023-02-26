// Script para previsualizar las imágenes

$(document).ready(function () {
    // Cuando se cambia el valor del campo de imagen, actualizamos la previsualización
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