<?php
session_start();
require_once '../config/Conexion.php';

class TablaCate extends Conexion
{

    protected static $cnx;
    private $idCategorianPk; 
    private $nombreCategoria;
    private $descripcion;

    public function __construct() {}

    //Metodos de conexion y desconexion 

    public static function getConexion()
    {
        self::$cnx = Conexion::conectar();
    }

    public static function desconectar()
    {
        self::$cnx = null;
    }

      // metodos set y get 

      public  function  getIdCategoriaPk()
      {
          return $this->idCategorianPk;
      }
  
      public  function  getNombreCategoria()
      {
          return $this->nombreCategoria;
      }

      public  function  getDescripcion()
      {
          return $this->descripcion;
      }
  
      public function setIdCategoriaPk($idCategorianPk){
          $this->idCategorianPk = $idCategorianPk;
      }
      public function setNombreCategoria($nombreCategoria){
          $this->nombreCategoria = $nombreCategoria;
      }
      public function setDescripcion($descripcion)
        {
            $this->descripcion = $descripcion;
        }

      public function listarTablaCate()
      {
          $query = "SELECT * from CATEGORIAS ";
          $arr = array();
          try {
              self::getConexion();
              
              $resultado = self::$cnx->prepare($query);
              $resultado->execute();
              self::desconectar();
              foreach ($resultado->fetchAll() as $encontrado) {
                  $client = new TablaCate();
                  $client->setIdCategoriaPk($encontrado['ID_CATEGORIA_PK']);
                  $client->setNombreCategoria($encontrado['NOMBRE_CATEGORIA']);
                  $client->setDescripcion($encontrado['DESCRIPCION']);
                  $arr[] = $client;
              }
              return $arr;
          } catch (PDOException $Exception) {
              self::desconectar();
              $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
              return json_encode($error);
          }
      }
      
      public function guardarCategoria(){
        $query = "INSERT INTO `categorias`(`ID_CATEGORIA_PK`, `NOMBRE_CATEGORIA`, DESCRIPCION)
         VALUES (:ID_CATEGORIA_PK,:NOMBRE_CATEGORIA,:DESCRIPCION)";
     try {
         self::getConexion();
         $id=$this->getIdCategoriaPk();
         $nombre=$this->getNombreCategoria();
         $descripcion=$this->getDescripcion();

        $resultado = self::$cnx->prepare($query);
        $resultado->bindParam(":ID_CATEGORIA_PK",$id,PDO::PARAM_INT);
        $resultado->bindParam(":NOMBRE_CATEGORIA",$nombre,PDO::PARAM_STR);
        $resultado->bindParam(":DESCRIPCION",$descripcion,PDO::PARAM_STR);
            $resultado->execute();
            self::desconectar();
           } catch (PDOException $Exception) {
               self::desconectar();
               $error = "Error ".$Exception->getCode( ).": ".$Exception->getMessage( );;
             return json_encode($error);
           }
    }

    public function verificarExistenciaDb($id){
        $query = "SELECT * FROM categorias where ID_CATEGORIA_PK=?";
     try {
         self::getConexion();
            $resultado = self::$cnx->prepare($query);		
            $resultado->bindParam(1,$id);
            $resultado->execute();
            self::desconectar();
            $encontrado = false;


            $nombre=$resultado->fetch();
            if ($nombre!=null)
            {
                $encontrado = true;
            }
            return $encontrado;
           } catch (PDOException $Exception) {
               self::desconectar();
               $error = "Error ".$Exception->getCode().": ".$Exception->getMessage();
             return $error;
           }
    }

    public function llenarCampos($id)
    {
        $query = "SELECT * FROM categorias where ID_CATEGORIA_PK=:ID_CATEGORIA_PK";
        try {
            self::getConexion();
            $resultado = self::$cnx->prepare($query);
            $resultado->bindParam(":ID_CATEGORIA_PK", $id, PDO::PARAM_INT);
            $resultado->execute();
            self::desconectar();
            foreach ($resultado->fetchAll() as $encontrado) {
                $this->setIdCategoriaPk($encontrado['ID_CATEGORIA_PK']);
                $this->setNombreCategoria($encontrado['NOMBRE_CATEGORIA']);
            }
        } catch (PDOException $Exception) {
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();;
            return json_encode($error);
        }
    }

    public function actualizarCategoria()
    {
        $query = "UPDATE categorias 
            SET NOMBRE_CATEGORIA = :NOMBRE_CATEGORIA,
            DESCRIPCION = :DESCRIPCION
            WHERE ID_CATEGORIA_PK = :ID_CATEGORIA_PK";
        try {
            self::getConexion();
            $id = $this->getIdCategoriaPk();
            $nombre = $this->getNombreCategoria();
            $descripcion = $this->getDescripcion();

            $resultado = self::$cnx->prepare($query);
            $resultado->bindParam(":ID_CATEGORIA_PK", $id, PDO::PARAM_INT);
            $resultado->bindParam(":NOMBRE_CATEGORIA", $nombre, PDO::PARAM_STR);
            $resultado->bindParam(":DESCRIPCION", $descripcion, PDO::PARAM_STR);

            self::$cnx->beginTransaction(); // desactiva el autocommit
            $resultado->execute();
            self::$cnx->commit(); // realiza el commit y vuelve al modo autocommit
            self::desconectar();

            return $resultado->rowCount();
        } catch (PDOException $Exception) {
            self::$cnx->rollBack();
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return $error;
        }
    }

}


?>
