<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: iniADM.php");
    exit;
}

include "mysqli_aux.php";

$server = "localhost";
$base = "dage-electronics";
$usr = "root";
$pass = "admin";


if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $borrar = "DELETE FROM productos WHERE id = $id";
    ejecutar($borrar, $server, $base, $usr, $pass);
}


$busquedaTexto = "";
if (isset($_GET['buscar'])) {
    $busquedaTexto = $_GET['buscar'];
    $query = "SELECT * FROM productos WHERE nombre LIKE '%$busquedaTexto%'";
} else {
    $query = "SELECT * FROM productos";
}

$datos = seleccionar($query, $server, $base, $usr, $pass);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">

<style>
body {
    margin: 0;
    min-height: 100vh;
    background: linear-gradient(#3E6478,#0cdeadcc);
    font-family: Arial;
}

.titulo {
    position: absolute;
    top: 20px;
    left: 20px;
    color: white;
    font-size: 32px;
    font-weight: bold;
}

.contenedor {
    display: flex;
    justify-content: center;
    margin-top: 130px;
}

.cuadro {
    background: #e6e6e6;
    width: 90%;
    max-width: 1100px;
    padding: 30px;
    border-radius: 12px;
}


.busqueda {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.cuadro h3 {
    margin: 0;
}


.buscador input {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}


.barra {
    background: white;
    padding: 20px;
    border-radius: 10px;
    max-height: 300px;
    overflow-y: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px;
}

th {
    background: #f2f2f2;
}

.botones {
    display: flex;
    justify-content: space-between;
    margin-top: 25px;
}

.btn-agregar {
    background: #7C4DFF;
    color: white;
    border: none;
    padding: 12px 24px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
}

.btn-cerrar {
    background: #1FD974;
    color: white;
    border: none;
    padding: 12px 24px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
}

.btn-agregar:hover,
.btn-cerrar:hover {
    opacity: 0.85;
}
</style>
</head>

<body>

<div class="titulo">Menú Administrador</div>

<div class="contenedor">
  <div class="cuadro">

    
    <div class="busqueda">
      <h3>Productos</h3>

      <form class="buscador" method="GET">
        <input type="text" name="buscar" placeholder="Buscar producto..." value="<?php echo $busquedaTexto; ?>">
      </form>
    </div>

    
    <div class="barra">
      <table>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Descripción</th>
          <th>Disponibilidad</th>
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
          <td><?php echo $fila[4]; ?></td>
          <td>
            <a href="menuADM.php?eliminar=<?php echo $fila[0]; ?>">Eliminar</a>
          </td>
          <td>
            <a href="Editar.php?id=<?php echo $fila[0]; ?>">Actualizar</a>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
          <td colspan="7">No se encontraron productos</td>
        </tr>
        <?php endif; ?>
      </table>
    </div>

    <div class="botones">
      <a href="Agregar.php">
        <button class="btn-agregar">Agregar nuevo producto</button>
      </a>

      <a href="iniADM.php">
        <button class="btn-cerrar">Cerrar sesión</button>
      </a>
    </div>

  </div>
</div>

</body>
</html>
