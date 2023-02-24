// Validates Repeat Password in register or change password forms
window.onload = function () {
    let form = document.getElementById("registerForm");
    form.onsubmit = function (e) {
        let passw = document.getElementById("password").value;
        let cpassw = document.getElementById("c-password").value;
        if (passw != cpassw) {
            e.preventDefault();
            document.getElementById("error").innerHTML="Password not equal";
        }
    }
}