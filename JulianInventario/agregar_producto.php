<?php
include 'db.php';

$nombre = $_POST['nombre'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$precio = $_POST['precio'] ?? 0;
$cantidad = $_POST['cantidad'] ?? 0;

if ($nombre && $categoria && $precio && $cantidad) {
    $stmt = $conexion->prepare("INSERT INTO productos (nombre, categoria, precio, cantidad) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $nombre, $categoria, $precio, $cantidad);
    if ($stmt->execute()) {
        echo "Producto agregado correctamente";
    } else {
        echo "Error al agregar: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Todos los campos son obligatorios.";
}
?>