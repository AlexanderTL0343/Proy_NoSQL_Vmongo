<?php
    require_once '../config/Conexion.php';

    class publicacion extends Conexion{
        //atributos
        protected static $conn;
        private $idPublicacion;
        private $idEstado;
        private $idCategoria;
        private $idCalificacion;
        private $tituloPublicacion;
        private $descripcion;
        private $fechaPublicacion;
        private $idUsuario;
        private $ubicacion;
        private $precioAprox;

        //Constructor
        public function __construct(){}

        //getters
        public function getIdPublicacion(){
            return $this->idPublicacion;
        }
        public function getIdEstado(){
            return $this->idEstado;
        }
        public function getIdCategoria(){
            return $this->idCategoria;
        }
        public function getIdCalificacion(){
            return $this->idCalificacion;
        }
        public function getTituloPublicacion(){
            return $this->tituloPublicacion;
        }
        public function getDescripcion(){
            return $this->descripcion;
        }
        public function getFechaPublicacion(){
            return $this->fechaPublicacion;
        }
        public function getIdUsuario(){
            return $this->idUsuario;
        }
        public function getUbicacion(){
            return $this->ubicacion;
        }
        public function getPrecioAprox(){
            return $this->precioAprox;
        }   
        //setters
        public function setIdPublicacion($idPublicacion){
            $this->idPublicacion = $idPublicacion;
        }
        public function setIdEstado($idEstado){
            $this->idEstado = $idEstado;
        }
        public function setIdCategoria($idCategoria){
            $this->idCategoria = $idCategoria;
        }
        public function setIdCalificacion($idCalificacion){
            $this->idCalificacion = $idCalificacion;
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
        public function setIdUsuario($idUsuario){
            $this->idUsuario = $idUsuario;
        }
        public function setUbicacion($ubicacion){
            $this->ubicacion = $ubicacion;
        }
        public function setPrecioAprox($precioAprox){
            $this->precioAprox = $precioAprox;
        }
        
        //Metodos de conexion y desconexion 

        public static function getConexion(){
            self::$conn = Conexion::conectar();
        }
        public static function desconectar(){
            self::$conn = null;
        }
        //----------------Métodos-----------------

        public function insertarPublicacion(){
            $SQL = "INSERT INTO PUBLICACIONES(ID_CATEGORIA_FK, TITULO_PUBLICACION, DESCRIPCION, ID_USUARIO_FK, UBICACION, PRECIO_APROX)
                    values (?,?,?,?,?,?)";
            try {
                self::getConexion();
                $res = self::$conn->prepare($SQL);
                $res->bindParam(1, $this->idCategoria);
                $res->bindParam(2, $this->tituloPublicacion);
                $res->bindParam(3, $this->descripcion);
                $res->bindParam(4, $this->idUsuario);
                $res->bindParam(5, $this->ubicacion);
                $res->bindParam(6, $this->precioAprox);
                $res->execute();
                self::desconectar();
                return true;
            } catch (PDOException $Exception) {
                self::desconectar(); //Esto lo robe del ejemplo crud
                $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
                error_log($error); // Log del error
                return false;
            }
        }

        public function listarPublicaciones(){
            $SQL = "SELECT * FROM PUBLICACIONES";
            try {
                self::getConexion();
                $res = self::$conn->prepare($SQL);
                $res->execute();
                self::desconectar();
                return $res->fetchAll();
            } catch (PDOException $Exception) {
                self::desconectar();
                $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
                return json_encode(["status" => false, "message" => $error]);
            }
        }

        public function listarCategorias(){
            $SQL = "SELECT * FROM CATEGORIAS";
            try {
                self::getConexion();
                $res = self::$conn->prepare($SQL);
                $res->execute();
                self::desconectar();
                return $res->fetchAll();
            } catch (PDOException $Exception) {
                self::desconectar();
                $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
                return json_encode(["status" => false, "message" => $error]);
            }
        }
    }
?>