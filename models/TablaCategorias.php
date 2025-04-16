<?php
session_start();
require_once '../config/ConexionAtlas.php';

class TablaCate extends ConexionAtlas
{

    protected static $cnx;
    private $idCategorianPk; 
    private $nombreCategoria;
    private $descripcion;

    public function __construct() {}

    //Metodos de conexion y desconexion 

    public static function getConexion()
    {
        self::$cnx = ConexionAtlas::conectar();
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
        try{
            $db = ConexionAtlas::conectar();

            $res = $db->CATEGORIAS->find();

            $resArray = iterator_to_array($res);

            $data = [];

            foreach ($resArray as $categoria) {
                $data[] = [
                    (string)$categoria['_id'],
                    $categoria['nombreCategoria'] ?? '',
                    $categoria['descripcion'] ?? '',
                    "<button class='btn btn-warning btn-sm'>Editar</button>" // Botón

    
                ];
            }  return [
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            ];
        } catch (MongoDB\Driver\Exception\Exception $Exception) {
            return [
                'error' => "Error " . $Exception->getCode() . ": " . $Exception->getMessage()
            ];
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
