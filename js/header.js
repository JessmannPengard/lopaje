$(document).ready(function () {

    // Cambio de color de la cabecera y los menús
    var posHeader = $('#header').offset().top;
    $(window).scroll(() => {
        var wPos = $(window).scrollTop();

        if (wPos > posHeader) {
            $('#header').css('background-color', '#fff');
            $('.nav-link a').css('color', '#415F69');
        } else {
            $('#header').css('background-color', '#415F69');
            $('.nav-link a').css('color', '#fff');
        }

    });
});