<?php
include "mysqli_aux.php";

$server = "localhost";
$base = "dage-electronics";
$usr = "root";
$pass = "admin";

$id = $_GET['id'];

$datos = seleccionar("SELECT * FROM productos WHERE id = $id", $server, $base, $usr, $pass);
$producto = $datos[0];

if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $disponibilidad = $_POST['disponibilidad'];

    $update = "UPDATE productos SET 
        nombre='$nombre',
        precio='$precio',
        descripcion='$descripcion',
        disponibilidad='$disponibilidad'
        WHERE id = $id";

    ejecutar($update, $server, $base, $usr, $pass);

    header("Location: menuADM.php");
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

.formulario {
    background: #e6e6e6;
    width: 450px;
    padding: 35px;
    border-radius: 12px;
}

h2 {
    text-align: center;
    margin-bottom: 25px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.btn-guardar {
    background: #7C4DFF;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

.btn-regresar {
    margin-top: 15px;
    background: #1FD974;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}

.btn-guardar:hover,
.btn-regresar:hover {
    opacity: 0.85;
}
</style>
</head>

<body>

<div class="formulario">
  <h2>Actualizar Producto</h2>

  <form method="POST">
    Nombre:
    <input type="text" name="nombre" value="<?= $producto[1] ?>" required>

    Precio:
    <input type="number" step="0.01" name="precio" value="<?= $producto[2] ?>" required>

    Descripción:
    <input type="text" name="descripcion" value="<?= $producto[3] ?>" required>

    Disponibilidad:
    <input type="number" name="disponibilidad" value="<?= $producto[4] ?>" required>

    <button type="submit" name="guardar" class="btn-guardar">Guardar Cambios</button>
  </form>

  <a href="menuADM.php">
    <button class="btn-regresar">Regresar al Menú</button>
  </a>
</div>

</body>
</html>
