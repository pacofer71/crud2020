<?php
require '../vendor/autoload.php';
$autor= new Clases\Autores();
$autor->rellenar(20);
$autor=null;