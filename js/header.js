$(document).ready(function () {
    var posHeader = $('#header').offset().top;
    $(window).scroll(() => {
        var wPos = $(window).scrollTop();

        // Header color transition
        if (wPos > posHeader) {
            $('#header').css('background-color', '#fff');
            $('.nav-link a').css('color', '#415F69');
        } else {
            $('#header').css('background-color', '#415F69');
            $('.nav-link a').css('color', '#fff');
        }

    });
});