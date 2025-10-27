<?php
include "conexion.php";

$server = "localhost";
$base = "tienditaES";
$usr = "root";
$pass = "admin"; 

if (isset($_POST['agregar'])) {
    $nombres = $_POST['nombres'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $insertar = "INSERT INTO productos (nombres, precio, descripcion)
                 VALUES ('$nombres', '$precio', '$descripcion')";
    ejecutar($insertar, $server, $base, $usr, $pass);
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $borrar = "DELETE FROM productos WHERE ID_PRODUCTO = $id";
    ejecutar($borrar, $server, $base, $usr, $pass);
}


$datos = seleccionar("SELECT * FROM productos", $server, $base, $usr, $pass);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Tiendita El Esfuerzo</title>
</head>
<body>
    <h2>Tiendita El Esfuerzo</h2>


    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombres" required><br><br>

        <label>Precio:</label><br>
        <input type="number"  name="precio" required><br><br>

        <label>Descripción:</label><br>
        <input type="text" name="descripcion" required><br><br>

        <input type="submit" name="agregar" value="Agregar producto">
    </form>

    <hr>

    <!-- Tabla de productos -->
    <table border>
        <tr>
            <th>ID_PRODUCTO</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Opción</th>
        </tr>

        <?php if ($datos): ?>
            <?php foreach ($datos as $fila): ?>
            <tr>
                <td><?php echo $fila[0]; ?></td>
                <td><?php echo $fila[1]; ?></td>
                <td><?php echo $fila[2]; ?></td>
                <td><?php echo $fila[3]; ?></td>
                <td><a href="tiendita.php?eliminar=<?php echo $fila[0]; ?>">Eliminar</a></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td>No hay productos registrados</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
