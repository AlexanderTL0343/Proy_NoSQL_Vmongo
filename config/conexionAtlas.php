<?php
use MongoDB\Driver\ServerApi;
require_once __DIR__ . '/../vendor/autoload.php';

class ConexionAtlas{ 
    private static $client = null;

    public static function obtenerConexion(){

        if (!self::$client) {
            $uri = 'mongodb+srv://Brandon:aRMivBdnimOgOzzS@cluster1-proyectonosql.tpf7t.mongodb.net/?retryWrites=true&w=majority&appName=Cluster1-ProyectoNoSQL';

            // Configurar API estable de MongoDB
            $apiVersion = new ServerApi(ServerApi::V1);

            //Crear cliente y conectar
            self::$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

            try {
                // Verificar conexión con un "ping"
                self::$client->selectDatabase('proyectoMongo')->command(['ping' => 1]);
                //echo "CONEXION EXITOSA";
            } catch (Exception $e) {
                error_log("Error de conexión a MongoDB: " . $e->getMessage());
                return null;
            }
        }
        return self::$client;
    }

    public static function desconectar(){
        self::$client = null; // Deja que PHP lo maneje
    }
}
//$dbv = ConexionAtlas::obtenerConexion();
?>