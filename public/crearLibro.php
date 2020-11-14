<!DOCTYPE html>
<?php
session_start();

require "../vendor/autoload.php";
//use League\Flysystem\Filesystem;
//use League\Flysystem\Adapter\Local;

use Clases\Autores;
use Clases\Libros;



$autor = new Autores();
$stmt = $autor->traerTodos(0, 200);
$autor = null;
//----------------------
function isImage($tipo)
{
    $imagenes = ["image/gif", "image/x-icon", "image/jpeg", "image/png", "image/svg+xml", "image/tiff", "image/webp"];
    return in_array($tipo, $imagenes);
}
function mostrarError($err)
{
    $_SESSION['error'] = $err;
    header("Location:{$_SERVER['PHP_SELF']}");
}



if (isset($_POST['crear'])) {
    $libro = new Libros();
    $titulo = trim(ucwords($_POST['titulo']));
    $isbn = $_POST['isbn'];
    $autor = $_POST['autor'];
    if (is_uploaded_file($_FILES['portada']['tmp_name'])) {
        if (isImage($_FILES['portada']['type'])) {
            $nombre = "./img/" . uniqid() . "_" . $_FILES['portada']['name'];
            move_uploaded_file($_FILES['portada']['tmp_name'], $nombre);
            $libro->setPortada($nombre);
        } else {
            $mensaje = "Error la portada debe ser un archivo de imagen";
            mostrarError($mensaje);
        }
    }

    $libro->setTitulo($titulo);
    $libro->setIsbn($isbn);
    $libro->setAutor($autor);
    $libro->create();
    $libro = null;
    $_SESSION['mensaje'] = "Libro creado Correctamente";
    header("Location:libros.php");
    $_SESSION['msg'] = "Libro guardado correctamente";
    header('Location:libros.php');
} else {

?>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

        <title>Nuevo Libro</title>
    </head>

    <body style="background-color: darksalmon">
        <h3 class="text-center mt-3">Crear Libro</h3>

        <div class="container mt-3">
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='text-light font-weight-bold bg-dark p-3'>{$_SESSION['error']}</p>";
                unset($_SESSION['error']);
            }
            ?>
            <form name="cautor" method='POST' action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype='multipart/form-data'>
                <div class="row">
                    <div class="col-1">
                        <label class="col-form-label">Título: </label>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" placeholder="titulo" required name="titulo">
                    </div>
                    <div class="col-1">
                        <label class="col-form-label">Autor: </label>
                    </div>
                    <div class="col-6">
                        <select name="autor" class="form-control">
                            <?php
                            while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value='{$fila->id_autor}'>{$fila->apellidos}, {$fila->nombre}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-1">
                        <label class="col-form-label">ISBN: </label>
                    </div>
                    <div class="col-4">
                        <input type="text" minlength=13 maxlength=13 required pattern="[0-9]{13}" name="isbn" class='form-control'>
                    </div>
                    <div class="col-1">
                        <label class="col-form-label">Portada:</label>
                    </div>
                    <div class="col">
                        <input type="file" class="form-control" id="p" name="portada">
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