<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {


$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$precio = floatval($_POST['precio']);
$cantidad = intval($_POST['cantidad']);
$total = $precio * $cantidad;

    // Verifica si hay suficiente inventario
    $stmt = $conexion->prepare("SELECT cantidad FROM productos WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->bind_result($cantidad_disponible);
    $stmt->fetch();
    $stmt->close();
    if ($cantidad_disponible >= $cantidad) {


// Registrar la venta
$stmt = $conexion->prepare("INSERT INTO ventas (nombre, categoria, precio, cantidad, total) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssdii", $nombre, $categoria, $precio, $cantidad, $total);
$stmt->execute();

// Restar del inventario
        $stmt = $conexion->prepare("UPDATE productos SET cantidad = cantidad - ? WHERE nombre = ?");
        $stmt->bind_param("is", $cantidad, $nombre);
        $stmt->execute();
        $stmt->close();

        // Redirige con mensaje de éxito
        header("Location: venta.php?mensaje=" . urlencode("✅ Venta registrada correctamente"));
        exit;
    } else {
        header("Location: venta.php?mensaje=" . urlencode("❌ Stock insuficiente para este producto"));
        exit;
    }
}
?>