<?php
    require_once '../config/conexionAtlas.php';
    require_once __DIR__ . '/../vendor/autoload.php';


    class Chat extends ConexionAtlas
    {
        //atributos
        private $idChat;
        private $participantes;
        private $fechaCreacion;
        private $ultimaActualizacion;
        private $idEstado;

        //Constructor
        public function __construct() {}

        //getters
        public function getIdChat(){
            return $this->idChat;
        }
        public function getParticipantes(){
            return $this->participantes;
        }
        public function getFechaCreacion(){
            return $this->fechaCreacion;
        }
        public function getUltimaActualizacion(){
            return $this->ultimaActualizacion;
        }
        public function getIdEstado(){
            return $this->idEstado;
        }
        //----------------Setters-----------------

        public function setIdChat($idChat){
            $this->idChat = $idChat;
        }
        public function setParticipantes($participantes){
            $this->participantes = $participantes;
        }
        public function setFechaCreacion($fechaCreacion){
            $this->fechaCreacion = $fechaCreacion;
        }
        public function setUltimaActualizacion($ultimaActualizacion){
            $this->ultimaActualizacion = $ultimaActualizacion;
        }
        public function setIdEstado($idEstado){
            $this->idEstado = $idEstado;
        }
        //----------------------------------------------------------------------------------

        public static function getConexion()
        {
            return ConexionAtlas::obtenerConexion();
        }
    
        public static function desconectar()
        {
            ConexionAtlas::desconectar();
        }
        //----------------Métodos-----------------

        public function listarChats($idUsuarioActual){
            
            try {
                $Conexion = self::getConexion();

                $res = $Conexion->CHATS->find( ['participantes' => intval($idUsuarioActual)] );

                self::desconectar();

                $chats = iterator_to_array($res);

                foreach ($chats as $chat) { //convertir de OBJECT ID a STRING
                    $chat['_id'] = (string) $chat['_id'];
                }

                return $chats;
            } catch (MongoDB\Driver\Exception\Exception $e) {
                // En caso de error, registrar el error en el log y retornar un mensaje de error
                error_log("Error al obtener chats: " . $e->getMessage());
                return [
                    "status" => false,
                    "message" => "Error al obtener chats."
                ]; 
            }
        }

        function obtenerChat($id){
            try {
                $Conexion = self::getConexion();

                if (is_numeric($id)) {
                    // Si el id es un número, usarlo directamente
                    $res = $Conexion->CHATS->findOne(['_id' => (int)$id]);
                } else {
                    // Si el id no es numérico, convertirlo a ObjectId
                    $objectId = new \MongoDB\BSON\ObjectId($id);
                    $res = $Conexion->CHATS->findOne(['_id' => $objectId]);
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
                error_log("Error al obtener chat: " . $e->getMessage());
                return false;
            }
        }

    }
?>