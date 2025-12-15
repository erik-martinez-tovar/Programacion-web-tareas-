<?php
session_start();

if (!isset($_SESSION['cliente'])) {
    header("Location: iniuser.php");
    exit;
}

include "mysqli_aux.php";

$server = "localhost";
$base   = "dage-electronics";
$usr    = "root";
$pass   = "admin";

if (isset($_GET['cat'])) {
    $categoria = $_GET['cat'];
    $query = "SELECT * FROM productos WHERE categoria = '$categoria'";
} else {
    $query = "SELECT * FROM productos";
}

$productos = seleccionar($query, $server, $base, $usr, $pass);
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

.barranave {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    padding: 20px 35px;
    background: linear-gradient(#39747F);
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.titulo {
    font-size: 32px;
    font-weight: bold;
    color: white;
}

.categorias {
    display: flex;
    justify-content: center;
    gap: 50px; 
}

.categorias a {
    color: white;
    text-decoration: none;
    font-size: 22px; 
    font-weight: bold;
}

.categorias a:hover {
    text-decoration: underline;
}

.acciones {
    display: flex;
    align-items: center;
    gap: 18px;
}

.btn-carrito {
    background: none;
    border: none;
    cursor: pointer;
}

.btn-carrito img {
    width: 55px;
    height: 55px;
}

.btn-cerrar {
    background: #e0e0e0;
    color: #333;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px; 
    font-weight: bold;
}

.red {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
    max-width: 1100px;
    margin: 35px auto;
    padding: 20px;
}

.carta {
    background: white;
    padding: 22px;
    border-radius: 14px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    text-align: center;
    transition: transform 0.3s;
}

.carta:hover {
    transform: scale(1.05);
}

.imagen-caja {
    width: 100%;
    height: 160px;
    margin-bottom: 15px;
}

.imagen-caja img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.precio {
    color: #15308F;
    font-weight: bold;
    font-size: 20px;
}

.disponible {
    color: black;
    font-weight: bold;
    font-size: 16px;
}

.no-disponible {
    color: red;
    font-weight: bold;
    font-size: 16px;
}

.btn-detalles {
    background: #23757A;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 10px;
    font-size: 18px;
    font-weight: bold;
}

.detalles {
    display: none;
    margin-top: 10px;
}

.detalles.visible {
    display: block;
}

.btn-agregar {
    background: #7C4DFF;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 12px;
    font-size: 18px;
    font-weight: bold;
}

.btn-agregar:disabled {
    background: #999;
    cursor: not-allowed;
}
</style>

<script>
function alternarDetalles(boton) {
    boton.nextElementSibling.classList.toggle("visible");
}
</script>

</head>

<body>

<div class="barranave">
    <div class="titulo">DAGE-ELECTRONICS</div>

    <div class="categorias">
        <a href="menuUser.php">Todos</a>
        <a href="menuUser.php?cat=pc">PC/Gaming</a>
        <a href="menuUser.php?cat=tf">Telefonía</a>
        <a href="menuUser.php?cat=ac">Accesorios</a>
    </div>

    <div class="acciones">
        <form action="carrito.php" method="POST">
            <button class="btn-carrito">
                <img src="img/carrito.png" alt="Carrito">
            </button>
        </form>

        <a href="iniuser.php">
            <button class="btn-cerrar">Cerrar sesión</button>
        </a>
    </div>
</div>

<div class="red">

<?php foreach ($productos as $p): ?>
  <div class="carta">

      <?php if (!empty($p[5])): ?>
          <div class="imagen-caja">
              <img src="img/<?php echo htmlspecialchars($p[5]); ?>" 
                   alt="<?php echo htmlspecialchars($p[1]); ?>">
          </div>
      <?php endif; ?>

      <h3><?php echo htmlspecialchars($p[1]); ?></h3>

      <p class="precio">$<?php echo htmlspecialchars($p[2]); ?></p>

      <?php if ($p[4] > 0): ?>
          <p class="disponible"><?php echo $p[4]; ?> disponibles</p>
      <?php else: ?>
          <p class="no-disponible">No disponible</p>
      <?php endif; ?>

      <button class="btn-detalles" onclick="alternarDetalles(this)">
          Detalles
      </button>

      <div class="detalles">
          <p><?php echo htmlspecialchars($p[3]); ?></p>
      </div>
<form method="POST" action="carrito.php">
    <input type="hidden" name="accion" value="agregar">
    <input type="hidden" name="id" value="<?php echo $p[0]; ?>">
    <button class="btn-agregar" <?php echo ($p[4] <= 0) ? 'disabled' : ''; ?>>
        Agregar al carrito
    </button>
</form>


  </div>
<?php endforeach; ?>

</div>

</body>
</html>
