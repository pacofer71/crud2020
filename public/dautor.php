<!DOCTYPE html>
<?php
if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}
session_start();
$id = $_GET['id'];

require "../vendor/autoload.php";

use Clases\Autores;

$autor = new Autores();
$autor->setId_autor($id);
$esteAutor = $autor->read();
$autor = null;

?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <title>Detalle Autor</title>
</head>

<body style="background-color: darksalmon">
    <h3 class="text-center mt-3">Detalle Autor</h3>

    <div class="container mt-3">
        <div class="card text-white bg-dark mb-3 m-auto" style="max-width: 38rem;">
            <div class="card-header text-center">Autor</div>
            <div class="card-body">

                <p class="card-text mb-2">Código:&nbsp;<?php echo $esteAutor->id_autor; ?></p>
                <p class="card-text mb-2">Apellidos:&nbsp;<?php echo $esteAutor->apellidos; ?></p>
                <p class="card-text mb-2">Nombre:&nbsp;<?php echo $esteAutor->nombre; ?></p>
                <p class="text-center"><a href="index.php" class="btn btn-info"><i class="fas fa-home  mr-2"></i>Inicio</a></p>
            </div>
        </div>
    </div>
</body>

</html>