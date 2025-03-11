<?php
session_start();
require_once '../config/Conexion.php';

class TablaPubli extends Conexion
{

    protected static $cnx;
    private $idPublicacionPk;
    private $idUsuarioFk;
    private $estado;
    private $tituloPublicacion;
    private $descripcion;
    private $fechaPublicacion;
    private $ubicacion;
    private $precioAprox;

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

    public  function  getIdPublicacionesPk()
    {
        return $this->idPublicacionPk;
    }

    public  function  getIdUsuarioFk()
    {
        return $this->idUsuarioFk;
    }
    public  function  getEstado()
    {
        return $this->estado;
    }
    public  function  getTituloPublicacion()
    {
        return $this->tituloPublicacion;
    }
    public  function  getDescripcion()
    {
        return $this->descripcion;
    }
    public  function  getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }
    public  function  getUbicacion()
    {
        return $this->ubicacion;
    }
    public  function  getPrecioAprox()
    {
        return $this->precioAprox;
    }

    public function setIdPublicacionesPk($idPublicacionPk){
        $this->idPublicacionPk = $idPublicacionPk;
    }
    public function setIdUsuarioFk($idUsuarioFk){
        $this->idUsuarioFk = $idUsuarioFk;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
    public function setTituloPublicacion($tituloPublicacion){
        $this->tituloPublicacion = $tituloPublicacion;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function setFechaPublicacion($fechaPublicacion){
        $this->fechaPublicacion = $fechaPublicacion;
    }
    public function setUbicacion($ubicacion){
        $this->ubicacion = $ubicacion;
    }
    public function setPrecioAprox($precioAprox){
        $this->precioAprox = $precioAprox;
    }

    //funcion para listar la tabla de los usuarios 

    public function listarTablaPubli()
    {
        $query = "SELECT p.ID_PUBLICACION_PK, p.ID_USUARIO_FK, p.TITULO_PUBLICACION, p.DESCRIPCION,
        p.FECHA_PUBLICACION, p.UBICACION, p.PRECIO_APROX, e.NOMBRE_ESTADO
          FROM publicaciones p
          JOIN estados e ON p.ID_ESTADO_FK = e.ID_ESTADO_PK";
        $arr = array();
        try {
            self::getConexion();
            
            $resultado = self::$cnx->prepare($query);
            $resultado->execute();
            self::desconectar();
            foreach ($resultado->fetchAll() as $encontrado) {
                $client = new TablaPubli();
                $client->setIdPublicacionesPk($encontrado['ID_PUBLICACION_PK']);
                $client->setIdUsuarioFk($encontrado['ID_USUARIO_FK']);
                $client->setTituloPublicacion($encontrado['TITULO_PUBLICACION']);
                $client->setDescripcion($encontrado['DESCRIPCION']);
                $client->setFechaPublicacion($encontrado['FECHA_PUBLICACION']);
                $client->setUbicacion($encontrado['UBICACION']);
                $client->setPrecioAprox($encontrado['PRECIO_APROX']);
                $client->setEstado($encontrado['NOMBRE_ESTADO']);
                $arr[] = $client;
            }
            return $arr;
        } catch (PDOException $Exception) {
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return json_encode($error);
        }
    }

    public function verificarExistenciaDb($id){
        $query = "SELECT * FROM publicaciones where ID_PUBLICACION_PK=?";
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

    public function llenarCampos($id){
        $query = "SELECT * FROM publicaciones where ID_PUBLICACION_PK=:ID_PUBLICACION_PK";
        try {
        self::getConexion();
        $resultado = self::$cnx->prepare($query);		 	
        $resultado->bindParam(":ID_PUBLICACION_PK",$id,PDO::PARAM_INT);
        $resultado->execute();
        self::desconectar();
        foreach ($resultado->fetchAll() as $encontrado) {
            $this->setIdPublicacionesPk($encontrado['ID_PUBLICACION_PK']);
            $this->setTituloPublicacion($encontrado['TITULO_PUBLICACION']);
        }
        } catch (PDOException $Exception) {
        self::desconectar();
        $error = "Error ".$Exception->getCode().": ".$Exception->getMessage();;
        return json_encode($error);
        }
    }

    public function actualizarPublicaciones()
    {
        $query = "UPDATE publicaciones 
        SET ID_USUARIO_FK = :ID_USUARIO_FK, 
            TITULO_PUBLICACION = :TITULO_PUBLICACION, 
            DESCRIPCION = :DESCRIPCION, 
            UBICACION = :UBICACION, 
            PRECIO_APROX = :PRECIO_APROX
            
        WHERE ID_PUBLICACION_PK = :ID_PUBLICACION_PK";
        try {
            self::getConexion();
            $id = $this->getIdPublicacionesPk();
            $usuario = $this->getIdUsuarioFk();
            $titulo = $this->getTituloPublicacion();
            $descripcion = $this->getDescripcion();
            $ubicacion = $this->getUbicacion();
            $precio = $this->getPrecioAprox();
        
            $resultado = self::$cnx->prepare($query);
            $resultado->bindParam(":ID_PUBLICACION_PK", $id, PDO::PARAM_INT);
            $resultado->bindParam(":ID_USUARIO_FK", $usuario, PDO::PARAM_INT);
            $resultado->bindParam(":TITULO_PUBLICACION", $titulo, PDO::PARAM_STR);
            $resultado->bindParam(":DESCRIPCION", $descripcion, PDO::PARAM_STR);
            $resultado->bindParam(":UBICACION", $ubicacion, PDO::PARAM_STR);
            $resultado->bindParam(":PRECIO_APROX", $precio, PDO::PARAM_INT);

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
    public function eliminarUsuario($id) {
        try {
            $sql = "UPDATE usuarios
            SET ID_ESTADO_FK = 2
            WHERE ID_USUARIO_PK = ?";
            self::getConexion();
            $stmt = self::$cnx->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            self::desconectar();
            return $rowCount; 
        } catch (PDOException $e) {
            self::desconectar();
            error_log("Error al eliminar usuario: " . $e->getMessage());
            return 0; 
        }
    }

    
}

?>