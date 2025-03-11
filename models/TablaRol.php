<?php
session_start();
require_once '../config/Conexion.php';

class TablaRol extends Conexion
{

    protected static $cnx;
    private $idRolPk;
    private $nombreRol;

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

    public  function  getIdRolPk()
    {
        return $this->idRolPk;
    }

    public  function  getNombreRol()
    {
        return $this->nombreRol;
    }

    public function setIdRolPk($idRolPk){
        $this->idRolPk = $idRolPk;
    }
    public function setNombreRol($nombreRol){
        $this->nombreRol = $nombreRol;
    }

    //funcion para listar la tabla de los usuarios 

    public function listarTablaRol()
    {
        $query = "SELECT * from roles ";
        $arr = array();
        try {
            self::getConexion();
            
            $resultado = self::$cnx->prepare($query);
            $resultado->execute();
            self::desconectar();
            foreach ($resultado->fetchAll() as $encontrado) {
                $client = new TablaRol();
                $client->setIdRolPk($encontrado['ID_ROL_PK']);
                $client->setNombreRol($encontrado['NOMBRE_ROL']);
                $arr[] = $client;
            }
            return $arr;
        } catch (PDOException $Exception) {
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return json_encode($error);
        }
    }

}

?>
