$(document).ready(function () {

    // Cambio de color de la cabecera y los menús,
    // el pie de página y el texto del pie
    var posHeader = $('#header').offset().top;
    $(window).scroll(() => {
        var wPos = $(window).scrollTop();

        if (wPos > posHeader) {
            $('#header').css('background-color', '#fff');
            $('#header').css('opacity', '.8');
            $('#footer').css('background-color', '#fff');
            $('#footer').css('opacity', '.8');
            $('.nav-link a').css('color', '#415F69');
            $('#footer-text').css('color', '#415F69');
        } else {
            $('#header').css('background-color', '#415F69');
            $('#header').css('opacity', '1');
            $('#footer').css('background-color', '#415F69');
            $('#footer').css('opacity', '1');
            $('.nav-link a').css('color', '#fff');
            $('#footer-text').css('color', '#fff');
        }

    });
});