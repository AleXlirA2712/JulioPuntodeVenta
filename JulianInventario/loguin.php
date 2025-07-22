<?php
  $username = "JulianBOSS";
  $password = "GymShopAlfa42390";
  session_start(); // Inicia la sesión

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submittedUsername = $_POST["username"];
    $submittedPassword = $_POST["password"];

    if ($submittedUsername == $username && $submittedPassword == $password) {
      $_SESSION["loggedIn"] = true; // Establece una variable de sesión
      header("Location: Index.php"); // Redirige a la página protegida
      exit(); // Importante: detener la ejecución después de la redirección
    } else {
      $error = "<p style='color:red;'>Nombre de usuario o contraseña incorrectos.</p>";
    }
  }
?>


<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body {
  font-family: sans-serif;
  margin: 0; /* Elimina márgenes predeterminados */
  padding: 0; /* Elimina rellenos predeterminados */
  display: flex; /* Centra el contenedor */
  justify-content: center;
  align-items: center;
  min-height: 100vh; /* Altura completa de la ventana */
  background-color:rgb(0, 0, 0); /* Color de fondo */
}

.container {
  width: 100%; /* Ocupa el 90% del ancho disponible */
  max-width: 650px; /* Ancho máximo */
  padding: 50px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: white; /* Fondo blanco para contraste */
  box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Sombra sutil */
}

label {
  display: block;
  margin-bottom: 15px;
}

input[type="text"],
input[type="password"],
input[type="submit"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  box-sizing: border-box;
}

input[type="submit"] {
  background-color:rgb(54, 54, 54);
  color: white;
  cursor: pointer;
}

/* Media query para pantallas pequeñas */
@media (max-width: 400px) {
  .container {
    max-width: 100%; /* Ocupa todo el ancho en pantallas pequeñas */
    padding: 15px; /* Reduce el relleno */
  }
  input[type="text"],
  input[type="password"],
  input[type="submit"] {
    padding: 8px; /* Reduce el relleno */
    font-size: 14px; /* Reduce el tamaño de la fuente */
  }
}

img{
    width: 100%;
    height: 100%;
    text-align: center
        
}
</style>
</head>
<body>
<div class="container">
    <img src="logoimg.png" >

  <h2>Iniciar Sesión</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="username">Usuario:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <input type="submit" value="Iniciar Sesión">



  </form>
<?php if(isset($error)){ echo $error;} ?>    <?php if(isset($error)){ echo $error;} ?>
  </form>
</div>
</body>
</html>