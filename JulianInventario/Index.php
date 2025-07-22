
<?php
// Aquí puedes incluir la lógica para insertar si quieres manejarlo todo desde index.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Inventario Gimnasio</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="shortcut icon" href="juliologo.ico" />

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 10px;
      padding: 0;
      background-color:rgb(255, 255, 255);
    }

    nav ul {
      list-style-type: none;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 0;
      background-color: #333;
      margin: 0 0 10px 0;
    }

    nav ul li {
      margin: 5px;
    }

    nav ul li a {
      display: block;
      padding: 10px 15px;
      color: white;
      text-decoration: none;
      background-color: #444;
      border-radius: 5px;
      font-size: 15px;
    }

    nav ul li a:hover {
      background-color: #28a745;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    form {
      background-color: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
      max-width: 500px;
      margin: auto;
    }

    input, select, button {
      width: 100%;
      padding: 1px;
      margin-top: 20px;
      font-size: 23px;
    }

    button {
      background-color: #28a745;
      border: none;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }

    .mensaje {
      text-align: center;
      color: green;
      margin-top: 10px;
    }

    @media screen and (max-width: 600px) {
      form {
        padding: 10px;
      }
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      word-break: break-word;
    }

    th, td {
      padding: 8px;
      border: 1px solid #ccc;
      text-align: left;
    }

    @media (max-width: 600px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      thead {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
      }

      td {
        position: relative;
        padding-left: 50%;
      }

      td::before {
        position: absolute;
        left: 10px;
        top: 10px;
        white-space: nowrap;
        font-weight: bold;
      }

      td:nth-of-type(1)::before { content: "ID"; }
      td:nth-of-type(2)::before { content: "Nombre"; }
      td:nth-of-type(3)::before { content: "Categoría"; }
      td:nth-of-type(4)::before { content: "Precio"; }
      td:nth-of-type(5)::before { content: "Cantidad"; }
      td:nth-of-type(6)::before { content: "Eliminar"; }
    }
  </style>
</head>
<body>

<!-- ✅ Menú con íconos -->
<nav>
  <ul>
    <li><a href="inventario.php">📦 Inventario</a></li>
    <li><a href="estadistica.php">📊 Estadísticas</a></li>
    <li><a href="venta.php">💸 Venta</a></li>
    <li><a href="registro_de_ventas.php">📄 Registro de Ventas</a></li>
    <li><a href="estadisticas_de_venta.php">📈 Estadisticas de ventas</a></li>
    <li><a href="Index.php">🔁 Recargar</a></li>


  </ul>
</nav>

<h1>Agregar Producto</h1>

<form id="formulario">
  <input type="text" name="nombre" placeholder="Nombre del producto" required>

  <!-- ✅ Selector de categoría -->
  <select name="categoria" required>
    <option value="">Selecciona una categoría</option>
    <option value="Ropa">Ropa</option>
    <option value="Accesorios">Accesorios</option>
    <option value="Suplementos">Suplementos</option>
  </select>

  <input type="number" step="0.01" name="precio" placeholder="Precio por unidad" required>
  <input type="number" name="cantidad" placeholder="Cantidad" required>
  <button type="submit">Guardar Producto</button>
  <div class="mensaje" id="mensaje"></div>
</form>

<script>
  const formulario = document.getElementById("formulario");
  const mensaje = document.getElementById("mensaje");

  formulario.addEventListener("submit", async (e) => {
    e.preventDefault();
    const datos = new FormData(formulario);
    const respuesta = await fetch("agregar_producto.php", {
      method: "POST",
      body: datos
    });
    const resultado = await respuesta.text();
    mensaje.textContent = resultado;
    formulario.reset();
  });
</script>

</body>
</html>

