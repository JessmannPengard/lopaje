<?php
// Script para hacer el logout
// Destruimos la sesión
session_start();
session_unset();
session_destroy();
// Y redirigimos a la página de login
header("Location: login.php");
?>