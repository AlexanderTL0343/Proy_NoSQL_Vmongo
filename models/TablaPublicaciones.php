<?php
session_start();
require_once '../config/conexionAtlas.php';

class TablaPubli extends conexionAtlas
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
        self::$cnx = conexionAtlas::conectar();
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
   

        try{
            $db = ConexionAtlas::conectar();
            
            $res = $db ->PUBLICACIONES ->aggregate([

                //JOIN CON ESTADO
                [
                    '$lookup' =>[
                        'from'=> 'ESTADO',
                        'localField' => 'id_estado_fk',
                        'foreignField' => '_id',
                        'as' => 'estado'
                    ]
                    ],

                //JOIN CON USUARIOS    
                [
                    '$lookup' => [
                        'from' => 'USUARIOS',
                        'localField' => 'id_usuario_fk',
                        'foreignField' => '_id',
                        'as' => 'usuario'
                    ]
                    ],

                // Desenrollar los arrays
                ['$unwind' => '$estado'],
                ['$unwind' => '$usuario'],  
            
                // Agregar campos útiles
                [
                    '$addFields' => [
                    'nombre_usuario' => '$usuario.nombreUsuario',
                    'nombre_estado' => '$estado.estado',
                            ]
                ]

            ]);

            $resArray = iterator_to_array($res);
            $data = [];

            foreach($resArray as $publicacion){
                $data[] = [
                    (string)$publicacion['_id'],
                    $publicacion['nombre_usuario'] ?? '',
                    $publicacion['titulo_publicacion'] ?? '',
                    $publicacion['descripcion'] ?? '',
                    $publicacion['fecha_publicacion'] ??
                    $publicacion['ubicacion'] ?? '',
                    $publicacion['precio_aprox'] ?? '',
                    $publicacion['nombre_estado'] ?? '',
                    "<button class='btn btn-warning btn-sm'>Editar</button>"
                    

                ];
            }

            return [
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            ];
        } catch (MongoDB\Driver\Exception\Exception $Exception) {
            return [
                'error' => "Error " . $Exception->getCode() . ": " . $Exception->getMessage()
            ];
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