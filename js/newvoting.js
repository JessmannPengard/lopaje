// Función para validar que las fechas sean correctas
function validarFechas(event) {

    var fechaInicio = new Date(document.getElementById("fecha-inicio").value);
    var fechaFin = new Date(document.getElementById("fecha-fin").value);
    var ahora = new Date();
    var txtError = document.getElementById("error");

    if (fechaInicio < ahora) {
        txtError.innerText = "La fecha de inicio debe ser posterior a la fecha actual";
        event.preventDefault();
        return;
    }

    if (fechaFin < fechaInicio) {
        txtError.innerText = "La fecha de finalización debe ser mayor que la fecha de inicio";
        event.preventDefault();
        return;
    }

}
