<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: registro.php");
    exit;
}

include "mysqli_aux.php";

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


if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombres = $_POST['nombres'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $update = "UPDATE productos 
               SET nombres='$nombres', precio='$precio', descripcion='$descripcion'
               WHERE ID_PRODUCTO = $id";

    ejecutar($update, $server, $base, $usr, $pass);
}


$datos = seleccionar("SELECT * FROM productos", $server, $base, $usr, $pass);

$productoEditar = null;
if (isset($_GET['actualizar'])) {
    $idEditar = $_GET['actualizar'];
    $consulta = "SELECT * FROM productos WHERE ID_PRODUCTO = $idEditar";
    $resultado = seleccionar($consulta, $server, $base, $usr, $pass);

    if ($resultado) {
        $productoEditar = $resultado[0];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Tiendita</title>
</head>
<body>
    <h2>Tiendita</h2>

    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombres" required><br><br>

        <label>Precio:</label><br>
        <input type="number" name="precio" required><br><br>

        <label>Descripción:</label><br>
        <input type="text" name="descripcion" required><br><br>

        <input type="submit" name="agregar" value="Agregar producto">
    </form>

    <hr>

    <table border>
        <tr>
            <th>ID_PRODUCTO</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Eliminar</th>
            <th>Actualizar</th>
        </tr>

        <?php if ($datos): ?>
            <?php foreach ($datos as $fila): ?>
            <tr>
                <td><?php echo $fila[0]; ?></td>
                <td><?php echo $fila[1]; ?></td>
                <td><?php echo $fila[2]; ?></td>
                <td><?php echo $fila[3]; ?></td>
                <td><a href="tiendita.php?eliminar=<?php echo $fila[0]; ?>">Eliminar</a></td>
                <td><a href="tiendita.php?actualizar=<?php echo $fila[0]; ?>">Actualizar</a></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No hay productos registrados</td></tr>
        <?php endif; ?>
    </table>

    <hr>

    <?php if ($productoEditar): ?>
        <h3>Actualizar producto</h3>
        <form method="POST">

            <input type="hidden" name="id" value="<?php echo $productoEditar[0]; ?>">

            <label>Nombre:</label><br>
            <input type="text" name="nombres" value="<?php echo $productoEditar[1]; ?>" required><br><br>

            <label>Precio:</label><br>
            <input type="number" name="precio" value="<?php echo $productoEditar[2]; ?>" required><br><br>

            <label>Descripción:</label><br>
            <input type="text" name="descripcion" value="<?php echo $productoEditar[3]; ?>" required><br><br>

            <input type="submit" name="actualizar" value="Guardar cambios">

        </form>
        <br>
        <a href="tiendita.php">Cancelar</a>
    <?php endif; ?>

    <a href="registro.php">
        <button>Regresar</button>
    </a>
</body>
</html>
