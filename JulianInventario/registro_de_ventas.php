<?php
include 'db.php';

// Eliminar todos los registros
if (isset($_POST['eliminar_todo'])) {
    $conexion->query("TRUNCATE TABLE ventas");
    $mensaje = "✅ Todos los registros han sido eliminados.";
}


$resultado = $conexion->query("SELECT * FROM ventas ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>


<?php if (isset($mensaje)) echo "<p style='color: green; text-align: center;'>$mensaje</p>"; ?>

    <meta charset="UTF-8">



    <style>
        body { font-family: sans-serif; padding: 20px; background: #f8f9fa; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #28a745; color: white; }
        h2 { text-align: center; }
        nav ul {
            list-style: none; display: flex; justify-content: center; padding: 0;
            background-color: #333; margin-bottom: 20px;
        }
        nav ul li { margin: 10px; }
        nav ul li a {
            color: white; text-decoration: none;
            background-color: #444; padding: 10px 15px; border-radius: 5px;
        }
        nav ul li a:hover { background-color: #28a745; }
    </style>
</head>
<body>

<nav>
    <ul>
 <li><a href="Index.php">🏠 Agregar Producto</a></li>
    <li><a href="inventario.php">📦 Inventario</a></li>
    <li><a href="estadistica.php">📊 Estadísticas</a></li>
    <li><a href="venta.php">💸 Venta</a></li>
    <li><a href="estadisticas_de_venta.php">📈 Estadisticas de ventas</a></li>
    <li><a href="registro_de_ventas.php">🔁 Recargar</a></li>

    </ul>
</nav>

<h2>📄 Registro de Ventas</h2>

    <form method="post" action="registro_de_ventas.php" onsubmit="return confirm('¿Seguro que deseas eliminar todos los registros?');" style="display: inline;">
        <button type="submit" name="eliminar_todo" style="background-color: #dc3545; color: white; padding: 10px 15px; border: none; border-radius: 5px;">🗑 Eliminar Todo</button>
    </form>
</div>



<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($venta = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $venta['fecha'] ?></td>
                <td><?= htmlspecialchars($venta['nombre']) ?></td>
                <td><?= htmlspecialchars($venta['categoria']) ?></td>
                <td>$<?= number_format($venta['precio'], 2) ?></td>
                <td><?= $venta['cantidad'] ?></td>
                <td>$<?= number_format($venta['total'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>