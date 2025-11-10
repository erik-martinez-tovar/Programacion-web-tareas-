<?php
session_start();
include "mysqli_aux.php";

$server = "localhost";
$base = "tienditaES";
$usr = "root";
$pass = "admin";

$ms = "";
$msCambio = "";

$mostrarCambio = isset($_GET['cambiar']);

if (isset($_POST['ingresar'])) {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasena='$contrasena'";
    $res = seleccionar($query, $server, $base, $usr, $pass);

    if ($res) {
        $_SESSION['usuario'] = $usuario;
        header("Location: tiendita.php");
        exit;
    } else {
        $ms = "Usuario o contraseña incorrectos.";
    }
}

if (isset($_POST['cambiarPass'])) {

    $usuario = "admin"; 
    $actual = $_POST['actual'];
    $nueva = $_POST['nueva'];
    $confirmar = $_POST['confirmar'];

    $query = "SELECT contrasena FROM usuarios WHERE usuario='$usuario'";
    $res = seleccionar($query, $server, $base, $usr, $pass);

    if ($res) {
        $passGuardada = $res[0][0];

        if ($actual !== $passGuardada) {
            $msCambio = "La contraseña actual es incorrecta.";
        } else if ($nueva !== $confirmar) {
            $msCambio = "Las contraseñas no coinciden.";
        } else {
            $update = "UPDATE usuarios SET contrasena='$nueva' WHERE usuario='$usuario'";
            ejecutar($update, $server, $base, $usr, $pass);
            $msCambio = "Contraseña cambiada con éxito.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso a Tiendita</title>
</head>
<body>

    <h2>Ingreso a Tiendita</h2>

    <?php if ($ms): ?>
        <p style="color:red;"><?php echo $ms; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contrasena" required><br><br>

        <input type="submit" name="ingresar" value="Ingresar">

        <a href="registro.php?cambiar=1">
            <button type="button">Cambiar contraseña</button>
        </a>
    </form>

    <hr>

    <?php if ($mostrarCambio): ?>

        <h3>Cambiar contraseña</h3>

        <?php if ($msCambio): ?>
            <p style="color:green;"><?php echo $msCambio; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Contraseña actual:</label><br>
            <input type="password" name="actual" required><br><br>

            <label>Nueva contraseña:</label><br>
            <input type="password" name="nueva" required><br><br>

            <label>Confirmar nueva contraseña:</label><br>
            <input type="password" name="confirmar" required><br><br>

            <input type="submit" name="cambiarPass" value="Guardar cambios">

            <a href="registro.php">
                <button type="button">Cancelar</button>
            </a>
        </form>

    <?php endif; ?>

</body>
</html>
