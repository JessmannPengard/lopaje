// Script para mostrar el lightbox al hacer click en las imágenes
$(document).ready(function () {
    $('.galeria img').on('click', function () {
        var rutaImagen = $(this).attr('src');
        var lightbox = '<div class="lightbox">' +
            '<img src="' + rutaImagen + '">' +
            '<i class="fa-solid fa-circle-xmark cerrar"></i>' +
            '</div>';
        $('body').append(lightbox);
        $('.cerrar').on('click', function (e) {
            e.preventDefault();
            $('.lightbox').remove();
        });
    });
});