<?php
session_start();
if(!isset($_POST['id'])){   
    header("Location:libros.php");
    die();
}
require "../vendor/autoload.php";
use Clases\Libros;
$id=$_POST['id'];
$libro=new Libros();
$libro->setId_libro($id);
$portada=$libro->devolverPortada($id);
if($portada!="./img/default.jpg") unlink($portada);
$libro->delete();
$libro=null;
$_SESSION['msg']="Libro Borrado Corectamente";
header('Location:libros.php');