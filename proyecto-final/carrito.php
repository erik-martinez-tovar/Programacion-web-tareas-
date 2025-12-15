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

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

function agregarProducto($id, $server, $base, $usr, $pass) {
    $query = "SELECT id, nombre, precio, imagen FROM productos WHERE id = $id";
    $producto = seleccionar($query, $server, $base, $usr, $pass)[0];

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad']++;
    } else {
        $_SESSION['carrito'][$id] = [
            'nombre'   => $producto[1],
            'precio'   => $producto[2],
            'cantidad' => 1,
            'imagen'   => $producto[3]
        ];
    }
}

function eliminarProducto($id) {
    unset($_SESSION['carrito'][$id]);
}

function actualizarCantidad($id, $cantidad) {
    if ($cantidad > 0) {
        $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
    }
}

function calcularTotal() {
    $total = 0;
    foreach ($_SESSION['carrito'] as $p) {
        $total += $p['precio'] * $p['cantidad'];
    }
    return $total;
}

function vaciarCarrito() {
    unset($_SESSION['carrito']);
}


if (isset($_POST['accion'])) {
    if ($_POST['accion'] === 'agregar') {
        agregarProducto($_POST['id'], $server, $base, $usr, $pass);
    }
    if ($_POST['accion'] === 'eliminar') {
        eliminarProducto($_POST['id']);
    }
    if ($_POST['accion'] === 'actualizar') {
        actualizarCantidad($_POST['id'], $_POST['cantidad']);
    }
    if ($_POST['accion'] === 'vaciar') {
        vaciarCarrito();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>DAGE-ELECTRONICS</title>
<script src="html2pdf.bundle.min.js"></script>

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

.contenedor {
    max-width: 1100px;
    margin: 40px auto;
    background: white;
    padding: 25px;
    border-radius: 14px;
}

.item {
    display: grid;
    grid-template-columns: 120px 1fr 200px 120px;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #ddd;
}

.item img { width: 100px; }

.form-cantidad {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.form-cantidad input {
    padding: 10px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid #ccc;
    text-align: center;
}

.btn {
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

.btn-eliminar { background: #e53935; color: white; }
.btn-seguir   { background: #23757A; color: white; }
.btn-vaciar   { background: gray; color: white; }
.btn-finalizar{ background: #23757A; color:white; }
.btn-pdf      { background: #555; color:white; }

.acciones-item { display: flex; justify-content: center; }

.total {
    text-align: right;
    font-size: 22px;
    font-weight: bold;
    margin-top: 20px;
}

input { width: 100%; padding: 10px; margin-bottom:12px; border-radius:8px; border:1px solid #ccc; }

#ticketPDF {
    display: none;
    background: white;
    padding: 20px;
    max-width: 600px;
    margin: 40px auto;
    font-family: Arial;
}
</style>
</head>

<body>

<div class="barranave">
    <div class="titulo">DAGE-ELECTRONICS</div>
</div>

<div class="contenedor">
<h2>Carrito de compras</h2>

<?php if (empty($_SESSION['carrito'])): ?>
<p>Tu carrito está vacío</p>

<div class="botones-carrito">
    <a href="menuUser.php"><button class="btn btn-seguir">Seguir comprando</button></a>
</div>

<?php else: ?>

<?php foreach ($_SESSION['carrito'] as $id => $p): ?>
<div class="item">
    <img src="img/<?php echo htmlspecialchars($p['imagen']); ?>">
    <div>
        <strong><?php echo htmlspecialchars($p['nombre']); ?></strong><br>
        $<?php echo htmlspecialchars($p['precio']); ?>
    </div>

    <form method="POST" class="form-cantidad">
        <input type="hidden" name="accion" value="actualizar">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="number" name="cantidad" value="<?php echo $p['cantidad']; ?>" min="1">
        <button class="btn">Actualizar</button>
    </form>

    <div class="acciones-item">
        <form method="POST">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button class="btn btn-eliminar">Eliminar</button>
        </form>
    </div>
</div>
<?php endforeach; ?>

<div class="total">Total: $<?php echo calcularTotal(); ?></div>

<div class="botones-carrito" style="display:flex; justify-content:space-between; margin-top:20px;">
    <a href="menuUser.php"><button class="btn btn-seguir">Seguir comprando</button></a>
    <form method="POST">
        <input type="hidden" name="accion" value="vaciar">
        <button class="btn btn-vaciar">Vaciar carrito</button>
    </form>
</div>

<?php endif; ?>
</div>

<div class="contenedor">
<h2>Finalizar compra</h2>

<input type="text" id="nombre" placeholder="Nombre completo">
<input type="text" id="telefono" placeholder="Teléfono">
<input type="text" id="direccion" placeholder="Dirección">
<input type="text" id="tarjeta" placeholder="Tarjeta de débito">

<div style="text-align:right;">
    <button class="btn btn-finalizar" onclick="finalizarCompra()">Finalizar compra</button>
    <button class="btn btn-pdf" onclick="descargarPDF()">Descargar ticket PDF</button>
</div>
</div>

<div id="ticketPDF">
<h2 style="text-align:center">DAGE-ELECTRONICS</h2>
<p><strong>Nombre:</strong> <span id="t-nombre"></span></p>
<p><strong>Teléfono:</strong> <span id="t-telefono"></span></p>
<p><strong>Dirección:</strong> <span id="t-direccion"></span></p>
<hr>
<h3>Productos</h3>
<?php foreach ($_SESSION['carrito'] as $p): ?>
<p><?php echo htmlspecialchars($p['nombre']); ?> x<?php echo $p['cantidad']; ?> — $<?php echo $p['precio']; ?></p>
<?php endforeach; ?>
<hr>
<h3>Total: $<?php echo calcularTotal(); ?></h3>
</div>

<script>
function finalizarCompra() {
    alert("Compra finalizada");
}

function descargarPDF() {
    document.getElementById("t-nombre").innerText = nombre.value;
    document.getElementById("t-telefono").innerText = telefono.value;
    document.getElementById("t-direccion").innerText = direccion.value;

    const ticket = document.getElementById("ticketPDF");

    ticket.style.display = "block";

    html2pdf().from(ticket).save("ticket_compra.pdf").then(() => {
        ticket.style.display = "none";
    });
}
</script>

</body>
</html>
