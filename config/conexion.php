<?php
require_once "global.php"; // Asegúrate de definir las constantes de conexión
require_once __DIR__ . '/../vendor/autoload.php';

class ConexionMongo
{
   // Método para obtener la conexión a MongoDB
   public static function obtenerConexion(): MongoDB\Database
   {
       try {
           // Crea un cliente y selecciona la base de datos
           $client = new MongoDB\Client("mongodb://localhost:27017");
           $db = $client->selectDatabase("proyectoMongo");

           return $db; // Retorna la conexión a la base de datos
       } catch (MongoDB\Driver\Exception\Exception $e) {
           die("❌ Error al conectar a MongoDB: " . $e->getMessage());
       }
   }
}

//$dbv = ConexionMongo::getDatabase();
?>