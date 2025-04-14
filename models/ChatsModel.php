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

                if (is_numeric($idUsuarioActual)) {
                    $idUsuarioActual = (int) $idUsuarioActual;
                } else {
                    // Si el id no es numérico, convertirlo a ObjectId
                    $idUsuarioActual = new \MongoDB\BSON\ObjectId($idUsuarioActual);
                }

                $res = $Conexion->CHATS->find( ['participantes' => $idUsuarioActual] );

                self::desconectar();

                $chats = iterator_to_array($res);

                foreach ($chats as $chat) {
                    // Convertir _id a string
                    $chat['_id'] = (string) $chat['_id'];
                
                    // Convertir participantes a string solo si son ObjectId
                     // Convertir participantes a string solo si son ObjectId
                    foreach ($chat['participantes'] as &$participante) {
                        if ($participante instanceof \MongoDB\BSON\ObjectId) {
                            $participante = (string) $participante;
                        }
                    }
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

        public function obtenerMensajes($idChat){
            try {
                $Conexion = self::getConexion();

                if (is_numeric($idChat)) {
                    // Si el id es un número, usarlo directamente
                    $res = $Conexion->MENSAJES->find(['id_chat_fk' => (int)$idChat]);
                } else {
                    // Si el id no es numérico, convertirlo a ObjectId
                    $objectId = new \MongoDB\BSON\ObjectId($idChat);
                    $res = $Conexion->MENSAJES->find(['id_chat_fk' => $objectId]);
                }

                self::desconectar();
                $res = iterator_to_array($res);

                if($res){
                    foreach ($res as $mensaje) {
                        $mensaje['_id'] = (string) $mensaje['_id'];
                        $mensaje['id_chat_fk'] = (string) $mensaje['id_chat_fk'];
                        $mensaje['id_emisor_fk'] = (string) $mensaje['id_emisor_fk']; // Agrega esta línea
                    }
    
                    return $res;
                }else{
                    return false;
                }

            } catch (MongoDB\Driver\Exception\Exception $e) {
                // Captura cualquier error en la conexión o inserción
                error_log("Error al obtener mensajes: " . $e->getMessage());
                return false;
            }
        }

        public function insertarChat(){
            try {
                $Conexion = self::getConexion();

                $chat = [
                    'participantes' => $this->getParticipantes(),
                    'fechaCreacion' => new MongoDB\BSON\UTCDateTime(),
                    'ultimaActualizacion' => new MongoDB\BSON\UTCDateTime(),
                    'idEstado' => 1
                ];//el estado es predeterminadamente 1 (activo)

                $res = $Conexion->CHATS->insertOne($chat);

                self::desconectar();

                if($res->getInsertedCount() == 1){
                    return true;
                }else{
                    return false;
                }
            } catch (MongoDB\Driver\Exception\Exception $e) {
                // Captura cualquier error en la conexión o inserción
                error_log("Error al insertar chat: " . $e->getMessage());
                return false;
            }
        }

        public function validarChatExistente($participantes){
            try {
                $Conexion = self::getConexion();

                //se parsean los id para eviar errores
                foreach ($participantes as &$p) {//el & es para editar el valor de arreglo
                    if (is_numeric($p)) {
                        $p = (int) $p;
                    }

                    if (is_string($p)) {
                        $p = new \MongoDB\BSON\ObjectId($p);
                    }
                }

                $cantidad = $Conexion->CHATS->countDocuments(['participantes' => ['$all' => $participantes]]);

                self::desconectar();

                if($cantidad > 0){
                    return true;
                }else{
                    return false;
                }
            } catch (MongoDB\Driver\Exception\Exception $e) {
                // Captura cualquier error en la conexión o inserción
                error_log("Error al validar chat repetido: " . $e->getMessage());
                return false;
            }
        }

        public function eliminarChat($idChat){
            try {
                $Conexion = self::getConexion();

                if (is_numeric($idChat)) {
                    $idChat = (int) $idChat;
                }

                if (is_string($idChat)) {
                    $idChat = new \MongoDB\BSON\ObjectId($idChat);
                }

                $res = $Conexion->CHATS->deleteOne(['_id' => $idChat]);

                self::desconectar();

                if($res->getDeletedCount() == 1){
                    return true;
                }else{
                    return false;
                }

            } catch (MongoDB\Driver\Exception\Exception $e) {
                // Captura cualquier error en la conexión o inserción
                error_log("Error al validar chat repetido: " . $e->getMessage());
                return false;
            }    
        }
        /*
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
        }*/

    }

?>