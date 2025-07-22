<?php
include 'db.php';

// Obtener productos existentes
$productos = $conexion->query("SELECT nombre, categoria, precio FROM productos ORDER BY categoria, nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Venta de Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: sans-serif;
            background: #f0f0f0;
            padding: 10px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #333;
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

        form {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #218838;
        }

        @media screen and (max-width: 600px) {
            nav ul li a {
                padding: 8px;
                font-size: 14px;
            }

            form {
                padding: 10px;
            }
        }

.mensaje {
    max-width: 400px;
    margin: 10px auto;
    padding: 10px;
    text-align: center;
    background-color: #d4edda;
    color: #155724;
    border-radius: 5px;
    border: 1px solid #c3e6cb;
    font-weight: bold;
}

    </style>
</head>
<body>

    <nav>
        <ul>
    <li><a href="Index.php">🏠 Agregar Producto</a></li>
    <li><a href="inventario.php">📦 Inventario</a></li>
    <li><a href="estadistica.php">📊 Estadísticas</a></li>
    <li><a href="registro_de_ventas.php">📄 Registro de Ventas</a></li>
    <li><a href="estadisticas_de_venta.php">📈 Estadisticas de ventas</a></li>
    <li><a href="venta.php">🔁 Recargar</a></li>

        </ul>
    </nav>

    <h2 style="text-align:center;">🛒 Registrar Venta</h2>

    <form action="procesar_venta.php" method="POST">
        <label for="producto">Producto:</label>
        <select name="nombre" id="producto" required>
            <option value="">-- Selecciona un producto --</option>
            <?php while ($p = $productos->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($p['nombre']) ?>"
                        data-categoria="<?= htmlspecialchars($p['categoria']) ?>"
                        data-precio="<?= $p['precio'] ?>">
                    <?= htmlspecialchars($p['nombre']) ?> (<?= htmlspecialchars($p['categoria']) ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <input type="hidden" name="categoria" id="categoria">
        <input type="hidden" name="precio" id="precio">

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" min="1" required>

        <button type="submit">💸 Realizar Venta</button>
    </form>

    <script>
        const selectProducto = document.getElementById('producto');
        const categoriaInput = document.getElementById('categoria');
        const precioInput = document.getElementById('precio');

        selectProducto.addEventListener('change', function () {
            const option = this.options[this.selectedIndex];
            categoriaInput.value = option.getAttribute('data-categoria');
            precioInput.value = option.getAttribute('data-precio');
        });
    </script>

<script>
    setTimeout(() => {
        const msg = document.querySelector('.mensaje');
        if (msg) msg.style.display = 'none';
    }, 4000); // Desaparece después de 4 segundos
</script>

</body>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="mensaje"><?= htmlspecialchars($_GET['mensaje']) ?></div>
<?php endif; ?>



</html>