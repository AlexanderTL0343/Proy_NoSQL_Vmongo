<?php
session_start();
require_once '../config/Conexion.php';

class TablaCali extends Conexion
{

    protected static $cnx;
    private $idCalificacionPk;
    private $idUsuarioFk;
    private $puntuacion;
    			


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

    public  function  getIdCalificacionPk()
    {
        return $this->idCalificacionPk;
    }
    public  function  getIdUsuarioFk()
    {
        return $this->idUsuarioFk;
    }
    public  function  getPuntuacion()
    {
        return $this->puntuacion;
    }

    public function setIdCalificacionPk($idCalificacionPk){
        $this->idCalificacionPk = $idCalificacionPk;
    }
    public function setIdUsuarioFk($idUsuarioFk){
        $this->idUsuarioFk = $idUsuarioFk;
    }
    public function setPuntuacion($puntuacion){
        $this->puntuacion = $puntuacion;
    }

    //funcion para listar la tabla de las calificaciones 

    public function listarTablaCali()
    {
        $query = "SELECT * from calificacion ";
        $arr = array();
        try {
            self::getConexion();
            
            $resultado = self::$cnx->prepare($query);
            $resultado->execute();
            self::desconectar();
            foreach ($resultado->fetchAll() as $encontrado) {
                $client = new TablaCali();
                $client->setIdCalificacionPk($encontrado['ID_CALIFICACION_PK']);
                $client->setIdUsuarioFk($encontrado['ID_USUARIO_FK']);
                $client->setPuntuacion($encontrado['PUNTUACION']);
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