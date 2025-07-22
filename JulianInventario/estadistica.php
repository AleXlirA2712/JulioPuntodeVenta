<?php
include 'db.php';

// Cantidad por categoría
$sql = "SELECT categoria, SUM(cantidad) AS total FROM productos GROUP BY categoria";
$res = $conexion->query($sql);

$categorias = [];
$totales = [];

while ($fila = $res->fetch_assoc()) {
    $categorias[] = $fila['categoria'];
    $totales[] = $fila['total'];
}

// Datos adicionales para estadísticas generales
$sql_total = "SELECT SUM(cantidad) as total_cantidad, SUM(cantidad * precio) as total_valor FROM productos";
$stats = $conexion->query($sql_total)->fetch_assoc();

$totalProductos = $stats['total_cantidad'];
$totalValor = $stats['total_valor'];
$promedio = ($totalProductos > 0) ? $totalValor / $totalProductos : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📊 Estadísticas de Inventario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        h2 { text-align: center; }
        canvas { display: block; margin: 0 auto 40px; max-width: 90%; }
        .stats {
            background: white; margin: 20px auto; padding: 20px; max-width: 600px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 10px;
        }
        .stats p { margin: 10px 0; font-size: 16px; }
        nav ul {
            list-style: none; padding: 0; margin: 0;
            display: flex; flex-wrap: wrap; justify-content: center;
            background-color: #333;
        }
        nav ul li { margin: 5px; }
        nav ul li a {
            text-decoration: none; color: white;
            background-color: #444; padding: 10px 15px;
            border-radius: 5px; display: block;
        }
        nav ul li a:hover { background-color: #28a745; }
    </style>
</head>
<body>

<!-- Menú -->
<nav>
    <ul>
    <li><a href="Index.php">🏠 Agregar Producto</a></li>
    <li><a href="inventario.php">📦 Inventario</a></li>
    <li><a href="venta.php">💸 Venta</a></li>
    <li><a href="registro_de_ventas.php">📄 Registro de Ventas</a></li>
    <li><a href="estadistica.php">🔁 Recargar</a></li>
    </ul>
</nav>

<!-- Título -->
<h2>📈 Productos por Categoría</h2>
<canvas id="graficaBarras"></canvas>

<h2>🥧 Distribución por Categoría</h2>
<canvas id="graficaPastel"></canvas>

<!-- Estadísticas numéricas -->
<div class="stats">
    <p><strong>Total de productos:</strong> <?= $totalProductos ?></p>
    <p><strong>Valor total del inventario:</strong> $<?= number_format($totalValor, 2) ?></p>
    <p><strong>Promedio de precio por producto:</strong> $<?= number_format($promedio, 2) ?></p>
</div>

<script>
    const categorias = <?= json_encode($categorias) ?>;
    const totales = <?= json_encode($totales) ?>;

    // Gráfico de barras
    new Chart(document.getElementById('graficaBarras').getContext('2d'), {
        type: 'bar',
        data: {
            labels: categorias,
            datasets: [{
                label: 'Cantidad total',
                data: totales,
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                borderColor: '#218838',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Inventario agrupado por categoría' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Gráfico de pastel
    new Chart(document.getElementById('graficaPastel').getContext('2d'), {
        type: 'pie',
        data: {
            labels: categorias,
            datasets: [{
                label: 'Distribución por categoría',
                data: totales,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Distribución porcentual por categoría' }
            }
        }
    });
</script>

</body>
</html>


