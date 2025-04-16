<?php
session_start();
require_once '../config/conexionAtlas.php';

class TablaRol extends conexionAtlas
{

    protected static $cnx;
    private $idRolPk;
    private $nombreRol;

    public function __construct() {}

    //Metodos de conexion y desconexion 

    public static function getConexion()
    {
        self::$cnx = conexionAtlas::conectar();
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
      try{
        $db = ConexionAtlas::conectar();

        $res = $db->ROLES->find();

        $resArray = iterator_to_array($res);

        $data = [];

        foreach ($resArray as $rol) {
            $data[] = [
                (string)$rol['_id'],
                $rol['rol'] ?? ''

            ];
        }
        return[
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ];
      }catch (MongoDB\Driver\Exception\Exception $Exception) {
        return [
            'error' => "Error " . $Exception->getCode() . ": " . $Exception->getMessage()
        ];
    }

    }

}

?>
