<?php
include 'db.php';

// Ventas por categoría
$sqlCat = "SELECT categoria, SUM(cantidad) AS total FROM ventas GROUP BY categoria";
$resCat = $conexion->query($sqlCat);
$categorias = [];
$totales = [];

while ($fila = $resCat->fetch_assoc()) {
    $categorias[] = $fila['categoria'];
    $totales[] = $fila['total'];
}

// Productos más vendidos
$sqlTop = "SELECT nombre, SUM(cantidad) AS total FROM ventas GROUP BY nombre ORDER BY total DESC LIMIT 5";
$resTop = $conexion->query($sqlTop);

// Ingresos diarios
$sqlDia = "SELECT DATE(fecha) AS dia, SUM(precio * cantidad) AS total FROM ventas GROUP BY dia ORDER BY dia";
$resDia = $conexion->query($sqlDia);
$dias = [];
$ingresos = [];

while ($fila = $resDia->fetch_assoc()) {
    $dias[] = $fila['dia'];
    $ingresos[] = $fila['total'];
}

// Ingreso total acumulado
$sqlTotal = "SELECT SUM(precio * cantidad) AS total FROM ventas";
$totalIngreso = $conexion->query($sqlTotal)->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📊 Estadísticas de Ventas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            padding: 10px;
            background: #f7f7f7;
        }

        h2, h3 {
            text-align: center;
        }

        .grafica, .tabla {
            max-width: 800px;
            margin: auto;
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background: #28a745;
            color: white;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
            display: flex;
            justify-content: center;
            background-color: #333;
            flex-wrap: wrap;
        }

        nav ul li {
            margin: 5px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            background-color: #444;
            padding: 10px 15px;
            border-radius: 5px;
            display: block;
        }

        nav ul li a:hover {
            background-color: #28a745;
        }
    </style>
</head>
<body>

<nav>
    <ul>
    <li><a href="Index.php">🏠 Agregar Producto</a></li>
    <li><a href="inventario.php">📦 Inventario</a></li>
    <li><a href="estadistica.php">📊 Estadísticas</a></li>
    <li><a href="venta.php">💸 Venta</a></li>
    <li><a href="registro_de_ventas.php">📄 Registro de Ventas</a></li>
    <li><a href="estadisticas_de_venta.php">🔁 Recargar</a></li>
    </ul>
</nav>

<h2>📊 Estadísticas de Ventas</h2>

<h3>1. Ventas por Categoría</h3>
<div class="grafica">
    <canvas id="ventasCategoria"></canvas>
</div>

<h3>2. Productos Más Vendidos</h3>
<div class="tabla">
    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad Vendida</th>
        </tr>
        <?php while ($fila = $resTop->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= $fila['total'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<h3>3. Ingresos por Día</h3>
<div class="grafica">
    <canvas id="ingresosDiarios"></canvas>
</div>

<h3>4. Ingreso Total</h3>
<p style="text-align:center; font-size: 20px; font-weight: bold; color: #28a745;">
    💵 $<?= number_format($totalIngreso, 2) ?> MXN
</p>

<script>
    // Ventas por categoría
    new Chart(document.getElementById("ventasCategoria"), {
        type: "bar",
        data: {
            labels: <?= json_encode($categorias) ?>,
            datasets: [{
                label: "Total Vendido",
                data: <?= json_encode($totales) ?>,
                backgroundColor: "rgba(40, 167, 69, 0.6)",
                borderColor: "#218838",
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Ingresos por día
    new Chart(document.getElementById("ingresosDiarios"), {
        type: "line",
        data: {
            labels: <?= json_encode($dias) ?>,
            datasets: [{
                label: "Ingresos ($)",
                data: <?= json_encode($ingresos) ?>,
                backgroundColor: "rgba(40, 167, 69, 0.3)",
                borderColor: "#218838",
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>