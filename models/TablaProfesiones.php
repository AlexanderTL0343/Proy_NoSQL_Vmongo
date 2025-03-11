<?php
session_start();
require_once '../config/Conexion.php';

class TablaProfe extends Conexion
{

    protected static $cnx;
    private $idProfesionPk; 
    private $nombreProfesion;

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

      public  function  getIdProfesionPk()
      {
          return $this->idProfesionPk;
      }
  
      public  function  getNombreProfesion()
      {
          return $this->nombreProfesion;
      }
  
      public function setIdProfesionPk($idProfesionPk){
          $this->idProfesionPk = $idProfesionPk;
      }
      public function setNombreProfesion($nombreProfesion){
          $this->nombreProfesion = $nombreProfesion;
      }

      public function listarTablaProfe()
      {
          $query = "SELECT * from Profesiones ";
          $arr = array();
          try {
              self::getConexion();
              
              $resultado = self::$cnx->prepare($query);
              $resultado->execute();
              self::desconectar();
              foreach ($resultado->fetchAll() as $encontrado) {
                  $client = new TablaProfe();
                  $client->setIdProfesionPk($encontrado['ID_PROFESION_PK']);
                  $client->setNombreProfesion($encontrado['NOMBRE_PROFESION']);
                  $arr[] = $client;
              }
              return $arr;
          } catch (PDOException $Exception) {
              self::desconectar();
              $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
              return json_encode($error);
          }
      }
      public function guardarProfesion(){
        $query = "INSERT INTO `profesiones`(`ID_PROFESION_PK`, `NOMBRE_PROFESION`) VALUES (:ID_PROFESION_PK,:NOMBRE_PROFESION)";
     try {
         self::getConexion();
         $id=$this->getIdProfesionPk();
         $nombre=$this->getNombreProfesion();

        $resultado = self::$cnx->prepare($query);
        $resultado->bindParam(":ID_PROFESION_PK",$id,PDO::PARAM_INT);
        $resultado->bindParam(":NOMBRE_PROFESION",$nombre,PDO::PARAM_STR);
            $resultado->execute();
            self::desconectar();
           } catch (PDOException $Exception) {
               self::desconectar();
               $error = "Error ".$Exception->getCode( ).": ".$Exception->getMessage( );;
             return json_encode($error);
           }
    }

    public function verificarExistenciaDb($id){
        $query = "SELECT * FROM profesiones where ID_PROFESION_PK=?";
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
        $query = "SELECT * FROM profesiones where ID_PROFESION_PK=:ID_PROFESION_PK";
        try {
            self::getConexion();
            $resultado = self::$cnx->prepare($query);
            $resultado->bindParam(":ID_PROFESION_PK", $id, PDO::PARAM_INT);
            $resultado->execute();
            self::desconectar();
            foreach ($resultado->fetchAll() as $encontrado) {
                $this->setIdProfesionPk($encontrado['ID_PROFESION_PK']);
                $this->setNombreProfesion($encontrado['NOMBRE_PROFESION']);
            }
        } catch (PDOException $Exception) {
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();;
            return json_encode($error);
        }
    }

    public function actualizarProfesion()
    {
        $query = "UPDATE profesiones 
            SET NOMBRE_PROFESION = :NOMBRE_PROFESION
            WHERE ID_PROFESION_PK = :ID_PROFESION_PK";
        try {
            self::getConexion();
            $id = $this->getIdProfesionPk();
            $nombre = $this->getNombreProfesion();

            $resultado = self::$cnx->prepare($query);
            $resultado->bindParam(":ID_PROFESION_PK", $id, PDO::PARAM_INT);
            $resultado->bindParam(":NOMBRE_PROFESION", $nombre, PDO::PARAM_STR);

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

