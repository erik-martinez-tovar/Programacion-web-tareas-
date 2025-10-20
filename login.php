<?php
session_start();

function cerrarSesion() {
    session_unset();
    setcookie("usuario", "", time() - 3600);
    setcookie("contrasena", "", time() - 3600);
    header("Location: login.php");
    exit();
}

function guardarCookies($usuario, $contrasena) {
    setcookie("usuario", $usuario, time() + 600);
    setcookie("contrasena", $contrasena, time() + 600);
}

function borrarCookies() {
    setcookie("usuario", "", time() - 3600);
    setcookie("contrasena", "", time() - 3600);
}

function iniciarSesion($usuario, $contrasena, $recordar = false) {
    if ($usuario == "admin" && $contrasena == "1234") {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["contrasena"] = $contrasena;
        $_SESSION["inicio"] = time();

        if ($recordar) {
            guardarCookies($usuario, $contrasena);
        } else {
            borrarCookies();
        }

        header("Location: inicio.php");
        exit();
    } else {
        header("Location: error.php");
        exit();
    }
}

if (isset($_POST["cerrar"])) {
    cerrarSesion();
}


$usuario = "";
$contrasena = "";
if (isset($_COOKIE["usuario"])) $usuario = $_COOKIE["usuario"];
if (isset($_COOKIE["contrasena"])) $contrasena = $_COOKIE["contrasena"];


if (isset($_POST["usuario"]) && isset($_POST["contrasena"])) {
    iniciarSesion($_POST["usuario"], $_POST["contrasena"], isset($_POST["recordar"]));
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
<h1>Inicio de sesión</h1>
<form method="POST">
    Usuario: <input type="text" name="usuario" value="<?php echo $usuario; ?>" required><br><br>
    Contraseña: <input type="password" name="contrasena" value="<?php echo $contrasena; ?>" required><br><br>
    <label><input type="checkbox" name="recordar"> Recuérdame</label><br><br>
    <input type="submit" value="Ingresar">
</form>
</body>
</html>
