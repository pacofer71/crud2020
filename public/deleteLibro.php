<?php
session_start();
if(!isset($_POST['id'])){   
    header("Location:libros.php");
    die();
}
require "../vendor/autoload.php";
use Clases\Libros;
$id=$_POST['id'];
$autor=new Libros();
$autor->setId_libro($id);
$autor->delete();
$autor=null;
$_SESSION['msg']="Libro Borrado Corectamente";
header('Location:libros.php');