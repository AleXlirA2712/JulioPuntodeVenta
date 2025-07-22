<?php
include 'db.php';

// Borrar producto si se solicita
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conexion->query("DELETE FROM productos WHERE id = $id");
    header("Location: inventario.php");
    exit;
}

// Filtros y búsqueda
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'categoria';
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$sql = "SELECT * FROM productos";
if ($busqueda !== '') {
    $sql .= " WHERE nombre LIKE '%" . $conexion->real_escape_string($busqueda) . "%'";
}
$sql .= " ORDER BY $orden, nombre";
$resultado = $conexion->query($sql);

// Inicia HTML
echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Inventario</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 10px;
            background: #f0f0f0;
        }

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
        }

        h2 {
            text-align: center;
        }

        .producto {
            background: white;
            padding: 10px;
            margin: 5px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .categoria {
            color: #28a745;
            margin-top: 20px;
        }

        .acciones a {
            margin-right: 10px;
            color: white;
            background-color: #dc3545;
            padding: 1px 10px;
            border-radius: 2px;
            text-decoration: none;
        }

        .acciones a:hover {
            background-color: #c82333;
        }

        .barra-busqueda {
            max-width: 600px;
            margin: 0 auto 20px auto;
            text-align: center;
        }

        .barra-busqueda input[type='text'] {
            width: 60%;
            padding: 7px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .barra-busqueda button {
            padding: 7px 12px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        .barra-busqueda button:hover {
            background-color: #218838;
        }

        @media screen and (max-width: 600px) {
            nav ul li a {
                padding: 8px;
                font-size: 14px;
            }

            .barra-busqueda input[type='text'] {
                width: 80%;
            }
        }
    </style>
</head>
<body>

<!-- Menú -->
<nav>
    <ul>
 <li><a href='Index.php'>🏠 Agregar Producto</a></li>
    <li><a href='estadistica.php'>📊 Estadísticas</a></li>
    <li><a href='registro_de_ventas.php'>📄 Registro de Ventas</a></li>
    <li><a href='estadisticas_de_venta.php'>📈 Estadisticas de ventas</a></li>
    <li><a href='inventario.php'>🔁 Recargar</a></li>


        
    </ul>
</nav>

<h2>📦 Inventario por Categoría</h2>

<!-- Barra de búsqueda -->
<div class='barra-busqueda'>
    <form method='GET' action=''>
        <input type='text' name='buscar' placeholder='Buscar producto...' value='" . htmlspecialchars($busqueda) . "'>
        <button type='submit'>🔍 Buscar</button>
        <a href='inventario.php'><button type='button'>❌ Limpiar</button></a>
    </form>
</div>";

$categoria_actual = "";
$total_categoria = 0;
$contador_categoria = 0;

while ($producto = $resultado->fetch_assoc()) {
    if ($producto['categoria'] !== $categoria_actual) {
        // Mostrar total de categoría anterior
        if ($categoria_actual !== "") {
            echo "<p style='margin-left:10px;'>🧮 Total productos: $contador_categoria | Cantidad total: $total_categoria</p>";
        }

        // Reiniciar contadores
        $categoria_actual = $producto['categoria'];
        $contador_categoria = 0;
        $total_categoria = 0;

        echo "<h3 class='categoria'>📁 " . htmlspecialchars($categoria_actual) . "</h3>";
    }

    $contador_categoria++;
    $total_categoria += $producto['cantidad'];

    echo "<div class='producto'>
        🏋 <strong>" . htmlspecialchars($producto['nombre']) . "</strong><br>
        💲 Precio por unidad: {$producto['precio']}<br>
        📦 Cantidad: {$producto['cantidad']}<br>
        <div class='acciones'>
            <a href='inventario.php?eliminar={$producto['id']}' onclick='return confirm(\"¿Seguro que quieres eliminar este producto?\")'>🗑 Eliminar</a>
        </div>
    </div>";
}

// Último total de categoría
if ($categoria_actual !== "") {
    echo "<p style='margin-left:10px;'>🧮 Total productos: $contador_categoria | Cantidad total: $total_categoria</p>";
}

echo "</body></html>";
?>