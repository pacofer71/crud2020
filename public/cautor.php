<!DOCTYPE html>
<?php
session_start();

require "../vendor/autoload.php";
use Clases\Autores;

    if(isset($_POST['crear'])){
        $n=trim(ucwords($_POST['nombre']));
        $a=trim(ucwords($_POST['apellidos']));
        if(strlen($a)==0 || strlen($n)==0){
            $_SESSION['error']="Rellene los  campos!!!";
            header("Location:{$_SERVER['PHP_SELF']}");
            die();
        }
        $autor=new Autores();
        $autor->setNombre($n);
        $autor->setApellidos($a);
        $autor->create();
        $autor=null;
        $_SESSION['msg']="Autor guardado correctamente";
        header('Location:index.php');

    }else{

    

?>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

  <title>Nuevo Autor</title>
</head>

<body style="background-color: darksalmon">
  <h3 class="text-center mt-3">Crear Autor</h3>
  
  <div class="container mt-3">
  <?php
      if(isset($_SESSION['error'])){
        echo "<p class='text-light font-weight-bold bg-dark p-3'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
      }
    ?>
  <form name="cautor" method='POST' action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <div class="row">
    <div class="col-4">
      <input type="text" class="form-control" placeholder="Nombre" required name="nombre">
    </div>
    <div class="col-8">
      <input type="text" class="form-control" placeholder="Apellidos" required name="apellidos">
    </div>
  </div>
  <div class="row mt-3">
      <div class="col">
         <button type="submit" class="btn btn-primary mr-3" name="crear"><i class="fas fa-plus  mr-2"></i>Crear</button>
         <button type="reset" class='btn btn-warning mr-3'>Limpiar</button>
         <a href="index.php" class="btn btn-info"><i class="fas fa-home  mr-2"></i>Inicio</a>
      </div>
  </div>
</form>
  </div>
</body>
</html>  
    <?php } ?>