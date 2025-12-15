<?php
include "mysqli_aux.php";

$server = "localhost";
$base = "dage-electronics";
$usr = "root";
$pass = "admin";

$ms = "";

if (isset($_POST['crear'])) {

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $verificar = "SELECT * FROM clientes WHERE correo='$correo'";
    $res = seleccionar($verificar, $server, $base, $usr, $pass);

    if ($res) {
        $ms = "Este correo ya está registrado.";
    } else {
        $insertar = "INSERT INTO clientes (correo, contrasena)
                     VALUES ('$correo', '$contrasena')";
        ejecutar($insertar, $server, $base, $usr, $pass);
        $ms = "Cuenta creada correctamente. Ya puedes iniciar sesión.";
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
      background: #f2f2f2;
      width: 590px;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      text-align: left;
}
h2 {
      text-align: center;
      margin-bottom: 25px;
}
input[type="email"],
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

  <h2>Crear cuenta</h2>

  <?php if ($ms): ?>
    <p style="color:green; text-align:center;"><?php echo $ms; ?></p>
  <?php endif; ?>

  <form method="POST">

      Correo electrónico:
      <input type="email" name="correo" required>

      Contraseña:
      <input type="password" name="contrasena" required>

      <button type="submit" name="crear" class="btn">Crear cuenta</button>

      <a href="iniuser.php" class="link">Volver al inicio de sesión</a>

  </form>

</div>

</body>
</html>
