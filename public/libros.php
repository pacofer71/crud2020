<?php
session_start();
require '../vendor/autoload.php';
$libro = new Clases\Libros();
$libro->rellenar(50);
$total = $libro->totalLibros();
$numPaginas = 4;
$totalPaginas = ($total % $numPaginas == 0) ? $total / $numPaginas : (int)(($total / $numPaginas) + 1);
$pagina = isset($_GET['page']) ? $_GET['page'] : 1;
$stmt = $libro->traerTodos(($pagina - 1) * $numPaginas, $numPaginas);
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
  <div class="container mt-3 container-fluid">
    <?php
    if (isset($_SESSION['msg'])) {
      echo "<p class='text-light font-weight-bold bg-dark p-3'>{$_SESSION['msg']}</p>";
      unset($_SESSION['msg']);
    }
    ?>
    <a href="cautor.php" class="btn btn-success"><i class="fas fa-user-plus mr-2"></i>Nuevo Libro</a>
    <table class="table table-striped table-dark mt-3" id='tlibros'>
      <thead>
        <tr>
          <th scope="col">Título</th>
          <th scope="col">Autor</th>
          <th scope="col">ISBN</th>
          <th scope="col">Portada</th>
          <th scope="col" class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
          echo <<<TXT
            <tr>
              <th scope="row">{$fila->titulo}</th>
              <td>{$fila->apellidos}, {$fila->nombre}</td>
              <td>{$fila->isbn}</td>
              <td><img src="{$fila->portada}" class="img-thumbnail" width='40px' height='40px'/></td>
              <td>
                <form name='f1' action='deleteLibro.php' method='POST' class='form-inline'>
                  <a href='dlibro.php?id={$fila->id_libro}' class='btn btn-primary mr-2'><i class="fas fa-user-check mr-2"></i>Detalle</a>
                  <a href='elibro.php?id={$fila->id_libro}' class='btn btn-warning mr-2 d-inline'><i class="fas fa-user-edit mr-2"></i>Editar</a>
                  <input type='hidden' name='id' value="{$fila->id_libro}" />
                  <button type="submit" class="btn btn-danger" onclick="return confirm('¿Borrar Libro?');"><i class="fas fa-user-minus mr-2"></i>Borrar</button>
                
                </form>
              </td>
            </tr>
          TXT;
        }
        ?>
      </tbody>
    </table>
    <?php
    for ($i = 1; $i <= $totalPaginas; $i++) {
      echo "| <a href='libros.php?page=$i'>$i</a> |";
    }
    ?>
  </div>
</body>

</html>