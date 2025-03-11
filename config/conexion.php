<?php
require_once "global.php";

class Conexion
{
    function __construct(){}

    public static function conectar(){
        try {
            $conn = new PDO("mysql:host=".DB_HOST_MYSQL.";dbname=".DB_NAME_MYSQL.";charset=utf8",DB_USER_MYSQL,DB_PASSWORD_MYSQL);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }
}
?>

<?php
require_once "global.php"; // Asegúrate de definir las constantes de conexión
require_once __DIR__ . '/../vendor/autoload.php';
class ConexionMongo
{
    private static $conn = null;

    public static function conectar()
    {
        try {
            if (self::$conn === null) {
                $client = new MongoDB\Client("mongodb://localhost:27017");
                self::$conn = $client->selectDatabase("proyectoMongo");
                //echo "<script>console.log('Conexión a MongoDB exitosa');</script>";
            }
            return self::$conn;
        } catch (MongoDB\Driver\Exception\Exception $ex) {
            die("Error de conexión: " . $ex->getMessage());      
        }
    }
}
//ConexionMongo::conectar();
?>