// Comprobamos que el password sea igual en el campo Repetir Password
window.onload = function () {
    let form = document.getElementById("registerForm");
    form.onsubmit = function (e) {
        let passw = document.getElementById("password").value;
        let cpassw = document.getElementById("c-password").value;
        if (passw != cpassw) {
            e.preventDefault();
            document.getElementById("error").innerHTML="La contraseña no coincide.";
        }
    }
}