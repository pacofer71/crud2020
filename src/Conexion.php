<?php
namespace Clases;
use PDO;
use PDOException;



class conexion{
    protected static $conexion;

    public function __construct(){
        if(self::$conexion==null){
            self::crearConexion();
        }
    }

    private static function crearConexion(){
        $opciones=parse_ini_file("../config.ini");
        $user=$opciones["usuario"];
        $pass=$opciones["pass"];
        $bbdd=$opciones["bbdd"];
        $dsn="mysql:host=localhost;dbname=$bbdd;charset=utf8mb4";
        try {
            self::$conexion = new PDO($dsn, $user, $pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $ex){
            die("Error al conectar a la base de datos!!!mensaje: ".$ex->getMessage());
        } 
    }
}