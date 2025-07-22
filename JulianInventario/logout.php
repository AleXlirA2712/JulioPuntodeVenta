<?php
  session_start();
  session_unset(); // Destruye la sesión
  session_destroy();
  header("Location: login.php"); // Redirige al login
  exit();
?>