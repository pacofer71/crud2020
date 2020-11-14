<?php
namespace Clases;
require "../vendor/autoload.php";
use Clases\Autores;
use PDOException;
use PDO;
class Libros extends Conexion{
    private $id_libro;
    private $titulo;
    private $isbn;
    private $autor;
    private $portada;

    public function __construct()
    {
        parent::__construct();
    }
    //------------------  setters      -----------------------------------------------


    /**
     * Set the value of id_libro
     *
     * @return  self
     */ 
    public function setId_libro($id_libro)
    {
        $this->id_libro = $id_libro;

        return $this;
    }

    /**
     * Set the value of titulo
     *
     * @return  self
     */ 
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Set the value of isbn
     *
     * @return  self
     */ 
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Set the value of autor
     *
     * @return  self
     */ 
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Set the value of portada
     *
     * @return  self
     */ 
    public function setPortada($portada)
    {
        $this->portada = $portada;

        return $this;
    }
    public function getPortada(){
        return $this->portada;
    }
    //----------------------------------   Otras funciones
     //Rellenar ------------------------------------------------------------------
     public function rellenar($cant)
     {
         $id=$this->traerAutores();
         if (!$this->hayLibros()) {
             $faker = \Faker\Factory::create('es_ES');
             for ($i = 0; $i < $cant; $i++) {
                 $titulo = $faker->sentence($nbWords = 5, $variableNbWords = true);
                 $isbn=$faker->isbn13;
                 $autor=$id[$faker->numberBetween($min=0, $max=count($id)-1)];
                 $ins="insert into libros(titulo, isbn, autor) values(:ti, :isbn, :au)";
                 $stmt = self::$conexion->prepare($ins);
                 try {
                     $stmt->execute([
                         ':ti' => $titulo,
                         ':isbn' => $isbn,
                         ':au'=>$autor
                     ]);
                 } catch (PDOException $ex) {
                     die("Error al crear libros, " . $ex->getMessage());
                 }
                 
 
             }
         }
     }
     //---------------------------------------------------------------------------------------------
     private function traerAutores(){
         $autor=new Autores();
         $id=$autor->devolverIdAutores();
         $autor=null;
         return $id;
     }
     //--------------------------------------------------------------------------------------------
     public function hayLibros()
     {
         $cons = "select count(*) from libros";
         $resultado = parent::$conexion->query($cons);
         if ($resultado->fetchColumn() > 0) return true;
         return false;
 
     }
     //-------------------------------------------------------------------------------------------------
    public function totalLibros() : Int{
        $cons = "select count(*) from libros";
        $numero=parent::$conexion->query($cons);
        return $numero->fetchColumn();
    }
    //------------------------------------------------------------------------------------------------------
    public function traerTodos($n, $t){
        $cons="select libros.*, apellidos, nombre from libros, autores where autor=id_autor order by apellidos, titulo limit $n, $t";
        $stmt=parent::$conexion->prepare($cons);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar los Libros!: ".$ex->getMessage());
        }
        return $stmt;
    }
    //--------------------------------------------------------------------------------------------------
    public function devolverPortada($i){
        $c="select portada from libros where id_libro=:i";
        $stmt=parent::$conexion->prepare($c);
        $stmt->execute([':i'=>$i]);
        $fila=$stmt->fetch(PDO::FETCH_OBJ);
        return $fila->portada;
    }
    //------------------------------------   CRUD -----------------------------------------------------------
    public function create(){
        $c1="insert into libros(titulo, autor, isbn, portada) values (:t, :a, :i, :p)";
        $c2="insert into libros(titulo, autor, isbn) values (:t, :a, :i)";
        $array=[':t'=>$this->titulo, ':a'=>$this->autor, ':i'=>$this->isbn];
        if(isset($this->portada)){
            $array[":p"]=$this->portada;
            $stmt=parent::$conexion->prepare($c1);
        }else{
            $stmt=parent::$conexion->prepare($c2);
        }
       
        try{
            $stmt->execute($array);
        }catch(PDOException $ex){
            die("Error al insertar el Libro: ".$ex->getMessage());
        }
    }
    public function delete(){
        $c="delete from libros where id_libro=:i";
        $stmt=parent::$conexion->prepare($c);
        try{
            $stmt->execute([':i'=>$this->id_libro]);
        }catch(PDOException $ex){
            die("Error al borrar libro ".$ex->getMessage());
        }
    }
}