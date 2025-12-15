<?php
session_start();
include "mysqli_aux.php";

$server = "localhost";
$base = "dage-electronics";
$usr = "root";
$pass = "admin";

$ms = "";
$msCambio = "";

$mostrarCambio = isset($_GET['cambiar']);

if (isset($_POST['ingresar'])) {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios 
              WHERE usuario='$usuario' AND contrasena='$contrasena'";
    $res = seleccionar($query, $server, $base, $usr, $pass);

    if ($res) {
        $_SESSION['usuario'] = $usuario;
        header("Location: menuADM.php");
        exit;
    } else {
        $ms = "Usuario o contraseña incorrectos";
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
            $update = "UPDATE usuarios 
                       SET contrasena='$nueva' 
                       WHERE usuario='$usuario'";
            ejecutar($update, $server, $base, $usr, $pass);
            $msCambio = "Contraseña cambiada con éxito.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">

<style>
body {
      margin: 0;
      height: 100vh;
      background: linear-gradient(#3E6478,#0cdeadcc);
      font-family: Arial;
      display: flex;
      justify-content: center;
      align-items: center;
}

.titulo {
      position: absolute;
      top: 20px;
      left: 20px;
}

h1 {
      color: white;
      font-size: 40px;
      margin: 30px;
}

.formulario {
      position: relative;
      background: #f2f2f2;
      width: 590px;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      text-align: left;
}

.btn-cliente {
      position: absolute;
      top: 15px;
      right: 15px;
      padding: 8px 14px;
      background: #1FD974;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
}

h2 {
      text-align: center;
      margin-bottom: 25px;
}

input[type="text"],
input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
}

.link {
      display: block;
      margin-bottom: 20px;
      color: #7C4DFF;
      text-decoration: none;
      font-size: 16px;
      text-align: center;
      padding: 10px;
}

.btn {
      width: 100%;
      padding: 12px;
      background: #7C4DFF;
      color: white;
      border: none;
      margin: 10px ;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
}
</style>
</head>

<body>

<div class="titulo">
  <h1>DAGE-ELECTRONICS</h1>
</div>

<div class="formulario">

<a href="iniuser.php">
   <button class="btn-cliente"> Cliente</button>
</a>

<?php if (!$mostrarCambio): ?>

  <h2>Inicio de sesión administrador</h2>

  <?php if ($ms): ?>
    <p style="color:red;"><?php echo $ms; ?></p>
  <?php endif; ?>

  <form method="POST">

      Usuario (admin):
      <input type="text" name="usuario" required>

      Contraseña (1234):
      <input type="password" name="contrasena" required>

      <a href="iniADM.php?cambiar=1" class="link">Cambiar contraseña</a>

      <button type="submit" name="ingresar" class="btn">Ingresar</button>

  </form>

<?php else: ?>
  
  <h2>Cambiar contraseña</h2>

  <?php if ($msCambio): ?>
      <p style="color:green;"><?php echo $msCambio; ?></p>
  <?php endif; ?>

  <form method="POST">
      Contraseña actual:
      <input type="password" name="actual" required>

      Nueva contraseña:
      <input type="password" name="nueva" required>

      Confirmar nueva contraseña:
      <input type="password" name="confirmar" required>

      <button type="submit" name="cambiarPass" class="btn">Guardar cambios</button>

      <a href="iniADM.php" class="link">Cancelar</a>
  </form>

<?php endif; ?>

</div>

</body>
</html>
