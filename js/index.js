$(document).ready(function () {

    // Mostrar el lightbox al hacer click en las imágenes
    $('.image-container').on('click', function () {
        var rutaImagen = $(this.querySelector('img')).attr('src');
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