<?php
session_start();

function cerrarSesion() {
    session_unset();
    setcookie("usuario", "", time() - 3600);
    setcookie("contrasena", "", time() - 3600);
    header("Location: login.php");
    exit();
}

function verificarSesion() {
    if (!isset($_SESSION["usuario"]) || !isset($_SESSION["contrasena"])) {
        cerrarSesion();
    }
    if (time() - $_SESSION["inicio"] > 600) {
        cerrarSesion();
    }
}

verificarSesion();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Inicio</title></head>
<body>
<h1>Bienvenido</h1>

<form action="login.php" method="POST">
    <input type="hidden" name="cerrar" value="1">
    <input type="submit" value="Cerrar sesión">
</form>
</body>
</html>
