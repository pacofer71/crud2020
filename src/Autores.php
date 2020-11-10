<?php
namespace Clases;

require '../vendor/autoload.php';

use PDOException;
use PDO;

class Autores extends Conexion
{
    private $id_autor;
    private $apellidos;
    private $nombre;

    public function __construct()
    {
        parent::__construct();
    }
    public function setId_autor($i){
        $this->id_autor=$i;
    }
    public function setNombre($n){
        $this->nombre=$n;
    }
    public function setApellidos($n){
        $this->apellidos=$n;
    }
    //-----------------------------------------------------------------------------------------
    public function traerTodos(){
        $cons="select * from autores order by apellidos, id_autor";
        $stmt=parent::$conexion->prepare($cons);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar los autores: ".$ex->getMessage());
        }
        return $stmt;
    }

    //Create ------------------
    public function create()
    {
        $crear="insert into autores(nombre, apellidos) values(:n, :a)";
        $stmt=parent::$conexion->prepare($crear);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos
            ]);
        }catch(PDOException $ex){
            die("Error al crear autor: ".$ex->getMessage());
        }
    }

    //Read ---------------------------------------------------
    public function read()
    {
        $c="select * from autores where id_autor=:i";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([
               ':i'=>$this->id_autor
            ]);
        }catch(PDOException $ex){
            die("Error al recuperar autor: ".$ex->getMessage());
        }
        return $stmt->fetch(PDO::FETCH_OBJ);

    }

    //Update --------------------------------------------------
    public function update()
    {
        $u="update autores set nombre=:n, apellidos=:a where id_autor=:i";
        $stmt=parent::$conexion->prepare($u);
        try{
            $stmt->execute([
               ':i'=>$this->id_autor,
               ':n'=>$this->nombre,
               ':a'=>$this->apellidos
            ]);
        }catch(PDOException $ex){
            die("Error al actualizar autor: ".$ex->getMessage());
        }

    }

    //delete --
    public function delete()
    {
        $del="delete from autores where id_autor=:i";
        $stmt=parent::$conexion->prepare($del);
        try{
            $stmt->execute([
                ':i'=>$this->id_autor
            ]);
        }catch(PDOException $ex){
            die("Error al borrar el autor, ".$ex->getMessage());
        }
    }
    //Rellenar ------------------------------------------------------------------
    public function rellenar($cant)
    {
        if (!$this->hayAutores()) {
            $faker = \Faker\Factory::create('es_ES');
            for ($i = 0; $i < $cant; $i++) {
                $nom = $faker->firstName();
                $ape = $faker->lastName() . ", " . $faker->lastName();
                $ins = "insert into autores(apellidos, nombre) values(:a, :n)";
                $stmt = self::$conexion->prepare($ins);
                try {
                    $stmt->execute([
                        ':a' => $ape,
                        ':n' => $nom,
                    ]);
                } catch (PDOException $ex) {
                    die("Error al crear autores, " . $ex->getMessage());
                }
                

            }
        }
    }
    //---------------------------------------------------------------------------------------------
    public function hayAutores()
    {
        $cons = "select count(*) from autores";
        $resultado = parent::$conexion->query($cons);
        if ($resultado->fetchColumn() > 0) return true;
        return false;

    }
    //--------------------------------------------------------------------------------------------
   
   

}
