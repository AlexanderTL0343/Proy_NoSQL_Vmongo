<?php
require_once '../config/conexionAtlas.php';
require_once __DIR__ . '/../vendor/autoload.php';


    class publicacion extends ConexionAtlas
    {
        //atributos
        private $idPublicacion;
        private $idEstado;
        private $idCategoria;
        private $idCalificacion;
        private $tituloPublicacion;
        private $descripcion;
        private $fechaPublicacion;
        private $idUsuario;
        private $ciudad;
        private $provincia;
        private $direccion;
        private $precioAprox;
        private $imagenUrl;

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
        public function getPrecioAprox(){
            return $this->precioAprox;
        }   
        public function getCiudad(){
            return $this->ciudad;
        }
        public function getProvincia(){
            return $this->provincia;
        }
        public function getDireccion(){
            return $this->direccion;
        }
        public function getImagenUrl(){
            return $this->imagenUrl;
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
        public function setPrecioAprox($precioAprox){
            $this->precioAprox = $precioAprox;
        }
        public function setCiudad($ciudad){
            $this->ciudad = $ciudad;
        }
        public function setProvincia($provincia){
            $this->provincia = $provincia;
        }
        public function setDireccion($direccion){
            $this->direccion = $direccion;
        }
        public function setImagenUrl($imagenUrl){
            $this->imagenUrl = $imagenUrl;
        }
        
        //---------------------------------------------------------------------------

        public static function getConexion()
        {
            return ConexionAtlas::obtenerConexion();
        }
    
        public static function desconectar()
        {
            ConexionAtlas::desconectar();
        }
        //----------------Métodos-----------------

        public function insertarPublicacion(){//MONGO HECHO //VALIDADO

            try {
                // Obtiene la conexión a la base de datos
                $conexion = self::getConexion();

                if(is_numeric($this->idEstado)){
                    $this->idEstado = (int) $this->idEstado;
                }else{
                    $this->idEstado = new \MongoDB\BSON\ObjectId($this->idEstado);
                }

                if(is_numeric($this->idCategoria)){
                    $this->idCategoria = (int) $this->idCategoria;
                }else{
                    $this->idCategoria = new \MongoDB\BSON\ObjectId($this->idCategoria);
                }

                if(is_numeric($this->idUsuario)){
                    $this->idUsuario = (int) $this->idUsuario;
                }else{
                    $this->idUsuario = new \MongoDB\BSON\ObjectId($this->idUsuario);
                }

                $publicacion = [
                    //el id se agrega solo, no en formato numerico pero se agrega XD
                    'id_estado_fk' => $this->idEstado,
                    'id_categoria_fk' => $this->idCategoria, 
                    'id_usuario_fk' => $this->idUsuario, 
                    'titulo_publicacion' => $this->tituloPublicacion, 
                    'descripcion' => $this->descripcion, 
                    'fecha_publicacion'=> new MongoDB\BSON\UTCDateTime(),
                    'imagen_url' => $this->imagenUrl, 
                    'precio_aprox' => (float) $this->precioAprox, 
                    'ubicacion' => [
                        'ciudad' => $this->ciudad,
                        'provincia' => $this->provincia,
                        'direccion_detallada' => $this->direccion
                    ],
                    'calificaciones' => [

                    ]    
                ];

                $res = $conexion->PUBLICACIONES->insertOne($publicacion);

                self::desconectar();

                if($res->getInsertedCount() == 1){
                    return true;
                }else{
                    return false;
                }
            } catch (MongoDB\Driver\Exception\Exception $e) {
                // Captura cualquier error en la conexión o inserción
                error_log("Error al insertar usuario: " . $e->getMessage());
                return false;
            }
        }

        public function listarPublicaciones(){//MONGO HECHO //VALIDADO
            
            try {
                $Conexion = self::getConexion();

                $res = $Conexion->PUBLICACIONES->find();

                self::desconectar();

                $publicaciones = iterator_to_array($res);

                foreach ($publicaciones as $publicacion) { //convertir de OBJECT ID a STRING
                    $publicacion['_id'] = (string) $publicacion['_id'];
                    $publicacion['id_estado_fk'] = (string) $publicacion['id_estado_fk'];
                    $publicacion['id_categoria_fk'] = (string) $publicacion['id_categoria_fk'];
                    $publicacion['id_usuario_fk'] = (string) $publicacion['id_usuario_fk'];
                }

                return $publicaciones;
            } catch (MongoDB\Driver\Exception\Exception $e) {
                // En caso de error, registrar el error en el log y retornar un mensaje de error
                error_log("Error al obtener profesiones: " . $e->getMessage());
                return [
                    "status" => false,
                    "message" => "Error al obtener profesiones."
                ]; 
            }
        }

        public function listarCategorias(){//MONGO HECHO //VALIDADO

            try {
                $Conexion = self::getConexion();
                $res = $Conexion->CATEGORIAS->find();
                self::desconectar();

                $categorias = iterator_to_array($res);

                foreach ($categorias as &$categoria) {
                    $categoria['_id'] = (string) $categoria['_id'];
                }

                return $categorias;                         
            } catch (MongoDB\Driver\Exception\Exception $e) {
                // En caso de error, registrar el error en el log y retornar un mensaje de error
                error_log("Error al obtener profesiones: " . $e->getMessage());
                return [
                    "status" => false,
                    "message" => "Error al obtener profesiones."
                ]; 
            }
        }

        public function eliminarPublicacion($id){//MONGO HECHO //VALIDADO
            try {
                $Conexion = self::getConexion();

                // Verificar si el id es un número o un ObjectId
                if (is_numeric($id)) {
                    // Si el id es un número, usarlo directamente
                    $res = $Conexion->PUBLICACIONES->deleteOne(['_id' => (int)$id]);
                } else {
                    // Si el id no es numérico, convertirlo a ObjectId
                    $objectId = new \MongoDB\BSON\ObjectId($id);
                    $res = $Conexion->PUBLICACIONES->deleteOne(['_id' => $objectId]);
                }

                self::desconectar();

                if($res->getDeletedCount() == 1){
                    return true;
                } else {
                    return false;
                }
            } catch (MongoDB\Driver\Exception\Exception $e) {
                // Captura cualquier error en la conexión o inserción
                error_log("Error al eliminar usuario: " . $e->getMessage());
                return false;
            }
        }

        public function obtenerPublicacion($id){//MONGO HECHO
            try {
                $Conexion = self::getConexion();

                if (is_numeric($id)) {
                    // Si el id es un número, usarlo directamente
                    $res = $Conexion->PUBLICACIONES->findOne(['_id' => (int)$id]);
                } else {
                    // Si el id no es numérico, convertirlo a ObjectId
                    $objectId = new \MongoDB\BSON\ObjectId($id);
                    $res = $Conexion->PUBLICACIONES->findOne(['_id' => $objectId]);
                }


                self::desconectar();

                if($res){
                    $res['_id'] = (string) $res['_id'];
                    return $res;
                } else {
                    return false;
                }
            } catch (MongoDB\Driver\Exception\Exception $e) {
                // Captura cualquier error en la conexión o inserción
                error_log("Error al obtener publicación: " . $e->getMessage());
                return false;
            }
        }

        //QUEDA PENDIENTE EL ACTUALIZAR PUBLICACION
    }
?>