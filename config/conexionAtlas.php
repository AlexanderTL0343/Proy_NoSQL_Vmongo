<?php
use MongoDB\Driver\ServerApi;
require_once "global.php";
require_once __DIR__ . '/../vendor/autoload.php';

class ConexionAtlas{ 
    private static $client = null; //PERMITE LA CONEXION AL CLUSTER Y SELECCION DE BSD
    private static $database = null; //USA LA BSD SELECCIONADA PARA EVITAR ESTARLA ESCRIBIENDO A CADA RATO EN LOS MODEL

    public static function obtenerConexion(){

        if (!self::$client) {
            $uri = 'mongodb+srv://'.DB_USER_MONGO.':'.DB_PASSWORD_MONGO.'@cluster1-proyectonosql.tpf7t.mongodb.net/?retryWrites=true&w=majority&appName=Cluster1-ProyectoNoSQL';

            // Configurar API estable de MongoDB
            $apiVersion = new ServerApi(ServerApi::V1);

            //Crear cliente y conectar
            self::$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

            try {
                // Verificar conexión con un "ping"
                self::$client->selectDatabase(DB_NAME_MONGO)->command(['ping' => 1]);
                //echo "CONEXION EXITOSA";
            } catch (Exception $e) {
                error_log("Error de conexión a MongoDB: " . $e->getMessage());
                return null;
            }
        }
         // Seleccionar la base de datos
         self::$database = self::$client->selectDatabase(DB_NAME_MONGO);
         return self::$database;// devuelve la base de datos en vez del cliente completo
    }

    public static function desconectar(){
        self::$client = null; // Deja que PHP lo maneje
        self::$database = null;
    }
}
//$dbv = ConexionAtlas::obtenerConexion();
?>