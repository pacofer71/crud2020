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
        $user="admin";
        $pass="secreto";
        $bbdd="daw1";
        $dsn="mysql:host=localhost;dbname=$bbdd;charset=utf8mb4";
        try {
            self::$conexion = new PDO($dsn, $user, $pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $ex){
            die("Error al conectar a la base de datos!!!mensaje: ".$ex->getMessage());
        } 
    }
}