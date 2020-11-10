<?php
session_start();
if(!isset($_POST['id'])){   
    header("Location:index.php");
    die();
}
require "../vendor/autoload.php";
use Clases\Autores;
$id=$_POST['id'];
$autor=new Autores();
$autor->setId_autor($id);
$autor->delete();
$autor=null;
$_SESSION['msg']="Autor Borrado Corectamente";
header('Location:index.php');