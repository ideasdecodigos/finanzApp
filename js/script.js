//OPEN AN WINDOW BY DEFAULT 
$(function () {
    $("#default").click();
    verifyCookies();

    $(window).scroll(function () {
        if ($(window).scrollTop() >= 32) {
            $('div.divbtn').css({
                'position': 'fixed',
                'top': 0,
                'width': '100%'
            });
        } else {
            $('div.divbtn').css({
                'position': 'relative',
            });
        }
    });
});

function notifications(tags) {
    Push.Permission.request();

    Push.create("Recordatorio de Cita!", {
        body: tags,
        icon: '../src/imgclear.png',
        timeout: 5000,
        vibrate: [100, 100, 100],
        onClick: function () {
            window.focus();
            window.location.href = window.location.href;
            this.close();
        }
    });
    Push.clear();
}

//OPEN AND CLOSE EVERY WINDOWS
function openwindows(btn, tagshow) {
    $('.divtab').css({
        'display': 'none'
    });
    $(tagshow).css({
        'display': 'block'
    });
    $('.btn').removeClass('active');
    $(btn).addClass('active');
}

//ALERTA DE COOKIES 
function aceptarCookies() {
    localStorage.aceptarCookies = 'true';
    $("#cajacookies").hide();
}

function verifyCookies() {
    if (localStorage.aceptarCookies == 'true') {
        $("#cajacookies").hide();
    }
    setTimeout(function () {
        $("#cajacookies").hide();
    }, 5000);
}

//iIMPRIMIR REPORTE
function imprSelecion(content) {
    var table = document.getElementById(content).innerHTML;
    var original = document.body.innerHTML;
    document.body.innerHTML = table;
    window.print();
    document.body.innerHTML = original;
}
