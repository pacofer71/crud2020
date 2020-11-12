<?php
session_start();
require '../vendor/autoload.php';
$libro = new Clases\Libros();
$libro->rellenar(50);
//$stmt = $libro->traerTodos();
$libro = null;

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

  <title>Libros</title>
</head>

<body style="background-color: darksalmon">
  <h3 class="text-center mt-3">Libros</h3>
  <div class="container mt-3">
    <?php
    if (isset($_SESSION['msg'])) {
      echo "<p class='text-light font-weight-bold bg-dark p-3'>{$_SESSION['msg']}</p>";
      unset($_SESSION['msg']);
    }
    ?>
    <a href="cautor.php" class="btn btn-success"><i class="fas fa-user-plus mr-2"></i>Nuevo Libro</a>
  </div>
</body>
</html> 