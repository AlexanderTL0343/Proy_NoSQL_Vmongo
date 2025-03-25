<?php
session_start();
require_once '../config/conexionAtlas.php';
require_once __DIR__ . '/../vendor/autoload.php';


class User extends ConexionAtlas
{
    private $id;
    private $idRol;
    private $idProfesion;
    private $cedula;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $edad;
    private $direccion;
    private $telefono;
    private $email;
    private $contrasena;
    private $facebook;
    private $instagram;
    private $fecha_registro;
    private $imagen_url;

    //Constructor
    public function __construct() {}

    public function getId()
    {
        return $this->id;
    }

    public function getIdRol()
    {
        return $this->idRol;
    }

    public function getCedula()
    {
        return $this->cedula;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido1()
    {
        return $this->apellido1;
    }

    public function getApellido2()
    {
        return $this->apellido2;
    }

    public function getIdProfesion()
    {
        return $this->idProfesion;
    }

    public function getEdad()
    {
        return $this->edad;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }

    public function getFacebook()
    {
        return $this->facebook;
    }

    public function getInstagram()
    {
        return $this->instagram;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    public function getImagenUrl()
    {
        return $this->imagen_url;
    }

    //----------------Setters-----------------

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdRol($idRol)
    {
        $this->idRol = $idRol;
    }

    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    }

    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
    }

    public function setIdProfesion($idProfesion)
    {
        $this->idProfesion = $idProfesion;
    }

    public function setEdad($edad)
    {
        $this->edad = $edad;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
    }

    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    public function setImagenUrl($imagen_url)
    {
        $this->imagen_url = $imagen_url;
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

    //-----------------------------------------------------------------------------------

    public function insertarUsuario(){//MONGO HECHO
        try {
            // Obtiene la conexión a la base de datos
            $conexion = self::getConexion();

            // Prepara el documento a insertar en MongoDB
            $usuario = [
                'id_rol_fk' => $this->idRol,
                'id_estado_fk' => 1, // Puedes ajustarlo según sea necesario
                'id_profesion_fk' => $this->idProfesion,
                'cedulaUsuario' => $this->cedula,
                'nombreUsuario' => $this->nombre,
                'apellido1' => $this->apellido1,
                'apellido2' => $this->apellido2,
                'edad' => $this->edad,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'contrasena' => $this->contrasena,
                'facebook' => '', // Puedes agregar más campos si es necesario
                'instagram' => '', // Puedes agregar más campos si es necesario
                'fechaRegistro' => new MongoDB\BSON\UTCDateTime(), // Fecha actual
                'imagen_url' => $this->imagen_url
            ];
    
            // Inserta el documento en la colección "USUARIOS"
            $result = $conexion->USUARIOS->insertOne($usuario);

            //DESCONECTAR DE MONGO
            self::desconectar();

            if($result->getInsertedCount() == 1){
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

    public function iniciarSesion2($email, $contrasena){//MONGO HECHO
        try {
            // Obtiene la conexión a MongoDB
            $conexion = self::getConexion();
    
            // Consulta de agregación
            $res = $conexion->USUARIOS->aggregate([
                ['$match' => ['email' => $email, 'contrasena' => $contrasena]],
                [
                    '$lookup' => [
                        'from' => 'ROLES',
                        'localField' => 'id_rol_fk',
                        'foreignField' => '_id',
                        'as' => 'rol'
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'ESTADOS',
                        'localField' => 'id_estado_fk',
                        'foreignField' => '_id',
                        'as' => 'estado'
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'PROFESIONES',
                        'localField' => 'id_profesion_fk',
                        'foreignField' => '_id',
                        'as' => 'profesion'
                    ]
                ],
                ['$unwind' => '$rol'],
                ['$unwind' => '$estado'],
                ['$unwind' => '$profesion'],
                [
                    '$addFields' => [
                        'nombre_rol' => '$rol.rol',
                        'nombre_estado' => '$estado.estado',
                        'nombre_profesion' => '$profesion.nombreProfesion'
                    ]
                ],
                [
                    '$project' => [
                        'rol' => 0,
                        'estado' => 0,
                        'profesion' => 0
                    ]
                ]
            ]);
    
            //DESCONECTAR DE MONGO
            self::desconectar();

            // Convierte el resultado a un array
            $usuario = iterator_to_array($res);
            
            // Verifica si hay resultados
            if (empty($usuario)) {
                error_log("No se encontró ningún usuario con el email y contraseña proporcionados.");
                return false;
            }
    
            // Asignamos los datos a la sesión
            $_SESSION['usuario'] = [
                'idUsuario' => $usuario[0]['_id'],
                'nombreRol' => $usuario[0]['nombre_rol'],
                'nombreEstado' => $usuario[0]['nombre_estado'],
                'nombreProfesion' => $usuario[0]['nombre_profesion'],
                'cedula' => $usuario[0]['cedulaUsuario'],
                'nombre' => $usuario[0]['nombreUsuario'],
                'apellido1' => $usuario[0]['apellido1'],
                'apellido2' => $usuario[0]['apellido2'],
                'edad' => $usuario[0]['edad'],
                'direccion' => $usuario[0]['direccion'],
                'telefono' => $usuario[0]['telefono'],
                'email' => $usuario[0]['email'],
                'facebook' => $usuario[0]['facebook'],
                'instagram' => $usuario[0]['instagram'],
                'fecha_registro' => $usuario[0]['fechaRegistro'],
                'imagen_url' => $usuario[0]['imagen_url']
            ];
    
            return true;
        } catch (MongoDB\Driver\Exception\Exception $Exception) {
            error_log("Error " . $Exception->getCode() . ": " . $Exception->getMessage());
            return false;
        }
    }
    
    public function obtenerProfesiones(){//MONGO HECHO
        try {
            // Crea una nueva instancia de ConexionMongo y obtiene la conexión a la bsd
            $Conexion = self::getConexion();
            
            // Consulta a la colección PROFESIONES
            $profesiones = $Conexion->PROFESIONES->find();
            
            // Convierte el cursor de MongoDB a un array
            $profesionesArray = iterator_to_array($profesiones);

            //DESCONECTAR DE MONGO
            self::desconectar();
    
            return $profesionesArray; // Retorna el array de profesiones
        } catch (MongoDB\Driver\Exception\Exception $e) {
            // En caso de error, registrar el error en el log y retornar un mensaje de error
            error_log("Error al obtener profesiones: " . $e->getMessage());
            return [
                "status" => false,
                "message" => "Error al obtener profesiones."
            ]; 
        }
    }

    public function insertarRedes(){
        $SQL = "UPDATE USUARIOS SET INSTAGRAM = ?, FACEBOOK = ? WHERE ID_USUARIO_PK = ?";

        try {
            self::getConexion();
            $res = self::$conn->prepare($SQL);
            
            $res->bindParam(1, $this->instagram);
            $res->bindParam(2, $this->facebook);
            $res->bindParam(3, $this->id);

            $res->execute();
            self::desconectar();
            return true;
        } catch (PDOException $Exception) {
            self::desconectar(); //Esto lo robe del ejemplo crud
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return false;
        }
    }

    public function verificarExistenciaDb($id){//MONGO HECHO **REVISAR FUNCIONALIDAD**
        try {
            // Obtiene la conexión a MongoDB
            $Conexion = ConexionAtlas::obtenerConexion();
    
            // Realiza la consulta en la colección "USUARIOS"
            $resultado = $Conexion->USUARIOS->findOne(['_id' => $id]);
    
            // Si se encuentra un usuario, retorna true, de lo contrario, false
            if ($resultado != null) {
                return true;  // Usuario encontrado
            } else {
                return false;  // Usuario no encontrado
            }
        } catch (MongoDB\Driver\Exception\Exception $Exception) {
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return $error;
        }
    }

    public function modificarUsuario() { //MONGO HECHO
        try {
            // Obtiene la conexión a MongoDB
            $Conexion = ConexionAtlas::obtenerConexion();
    
            // Recoge los valores necesarios para la actualización
            $id = $this->getId();
            $nombre = $this->getNombre();
            $direccion = $this->getDireccion();
            $telefono = $this->getTelefono();
            $email = $this->getEmail();
            $instagram = $this->getInstagram();
            $facebook = $this->getFacebook();
            $cedula = $this->getCedula();
            $imagen_url = $this->getImagenUrl();
            $profesion = (int) $this->getIdProfesion();
    
            // Prepara el array de actualización con los nombres correctos
            $updateData = [
                'nombreUsuario' => $nombre,          
                'direccion' => $direccion,           
                'telefono' => $telefono,             
                'email' => $email,                  
                'instagram' => $instagram,           
                'facebook' => $facebook,            
                'cedulaUsuario' => $cedula,          
                'imagen_url' => $imagen_url,         
                'id_profesion_fk' => $profesion     
            ];
    
            if(is_numeric($id)){
                $id = (int)$id;
            }else{
                $id = new \MongoDB\BSON\ObjectId($id);
            }


            // Realiza la actualización en la colección "USUARIOS"
            $resultado = $Conexion->USUARIOS->updateOne(
                ['_id' => $id],  // Filtro para encontrar al usuario por su ID
                ['$set' => $updateData]                     // Datos a actualizar
            );
    
            // Verifica si la actualización fue exitosa
            if ($resultado->getModifiedCount() > 0) {
                return $resultado->getModifiedCount();  // Devuelve el número de documentos modificados
            } else {
                return 0;  // No se realizaron cambios
            }
        } catch (MongoDB\Driver\Exception\Exception $Exception) {
            // Manejo de errores
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return $error;
        }
    }
    
    public function obtenerUsuario($id){ //MONGO HECHO
        try {
            $Conexion = self::getConexion();

            if(is_numeric($id)){
                $res = $Conexion->USUARIOS->aggregate([
                    ['$match' => ['_id' => (int)$id]],
                    [
                        '$lookup' => [
                            'from' => 'ROLES',
                            'localField' => 'id_rol_fk',
                            'foreignField' => '_id',
                            'as' => 'rol'
                        ]
                    ],
                    [
                        '$lookup' => [
                            'from' => 'ESTADOS',
                            'localField' => 'id_estado_fk',
                            'foreignField' => '_id',
                            'as' => 'estado'
                        ]
                    ],
                    [
                        '$lookup' => [
                            'from' => 'PROFESIONES',
                            'localField' => 'id_profesion_fk',
                            'foreignField' => '_id',
                            'as' => 'profesion'
                        ]
                    ],
                    ['$unwind' => '$rol'],
                    ['$unwind' => '$estado'],
                    ['$unwind' => '$profesion'],
                    [
                        '$addFields' => [
                            'nombre_rol' => '$rol.rol',
                            'nombre_estado' => '$estado.estado',
                            'nombre_profesion' => '$profesion.nombreProfesion'
                        ]
                    ],
                    [
                        '$project' => [
                            'rol' => 0,
                            'estado' => 0,
                            'profesion' => 0
                        ]
                    ]
                ]);

            }else{

                $objectId = new \MongoDB\BSON\ObjectId($id);
                $res = $Conexion->USUARIOS->aggregate([
                    ['$match' => ['_id' => $objectId]],
                    [
                        '$lookup' => [
                            'from' => 'ROLES',
                            'localField' => 'id_rol_fk',
                            'foreignField' => '_id',
                            'as' => 'rol'
                        ]
                    ],
                    [
                        '$lookup' => [
                            'from' => 'ESTADOS',
                            'localField' => 'id_estado_fk',
                            'foreignField' => '_id',
                            'as' => 'estado'
                        ]
                    ],
                    [
                        '$lookup' => [
                            'from' => 'PROFESIONES',
                            'localField' => 'id_profesion_fk',
                            'foreignField' => '_id',
                            'as' => 'profesion'
                        ]
                    ],
                    ['$unwind' => '$rol'],
                    ['$unwind' => '$estado'],
                    ['$unwind' => '$profesion'],
                    [
                        '$addFields' => [
                            'nombre_rol' => '$rol.rol',
                            'nombre_estado' => '$estado.estado',
                            'nombre_profesion' => '$profesion.nombreProfesion'
                        ]
                    ],
                    [
                        '$project' => [
                            'rol' => 0,
                            'estado' => 0,
                            'profesion' => 0
                        ]
                    ]
                ]);
            }

            self::desconectar();

            $usuario = iterator_to_array($res);

            $usuario[0]['_id'] = (string) $usuario[0]['_id'];

            if (empty($usuario) || $usuario == null) {
                return false;
            }else{
                return json_encode($usuario[0]);
            }        
           
        } catch (MongoDB\Driver\Exception\Exception $Exception) {
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return $error;
        }
    }

    public function listarUsuarios(){ //MONGO HECHO
        try {
            $Conexion = self::getConexion();

            $res = $Conexion->USUARIOS->find();

            self::desconectar();

            $usuarios = iterator_to_array($res);

            foreach ($usuarios as $usuario) { //convertir de OBJECT ID a STRING
                $usuario['_id'] = (string) $usuario['_id'];
            }

            return $usuarios;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            // En caso de error, registrar el error en el log y retornar un mensaje de error
            error_log("Error al obtener profesiones: " . $e->getMessage());
            return [
                "status" => false,
                "message" => "Error al obtener profesiones."
            ]; 
        }
    }

    public function actualizarVariablesSesion($id){ //MONGO HECHO
        $usuario = json_decode($this->obtenerUsuario($id), true);
        
        if($usuario){
            $_SESSION['usuario'] = [
                'idUsuario' => $usuario['_id'],
                'nombreRol' => $usuario['nombre_rol'],
                'nombreEstado' => $usuario['nombre_estado'],
                'nombreProfesion' => $usuario['nombre_profesion'],
                'cedula' => $usuario['cedulaUsuario'],
                'nombre' => $usuario['nombreUsuario'],
                'apellido1' => $usuario['apellido1'],
                'apellido2' => $usuario['apellido2'],
                'edad' => $usuario['edad'],
                'direccion' => $usuario['direccion'],
                'telefono' => $usuario['telefono'],
                'email' => $usuario['email'],
                'facebook' => $usuario['facebook'],
                'instagram' => $usuario['instagram'],
                'fecha_registro' => $usuario['fechaRegistro'],
                'imagen_url' => $usuario['imagen_url']
            ];     
            return true;
        }else{
            return false;
        }
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //aqui pintamos los graficos 
/*
    public function obtenerDatosGraficos()
    {
        $SQL = "SELECT count(*) as cantidad, NOMBRE_ROL FROM USUARIOS INNER JOIN ROLES ON USUARIOS.ID_ROL_FK = ROLES.ID_ROL_PK GROUP BY NOMBRE_ROL";
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

    public function obtenerUsuariosPorEdad()
    {
        $SQL = "SELECT count(*) as CANTIDAD, EDAD FROM USUARIOS GROUP BY EDAD";
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

    public function obtenerUsuariosPorProfesion()
    {
        $SQL = "SELECT p.NOMBRE_PROFESION, COUNT(*) AS CANTIDAD FROM PROFESIONES p JOIN USUARIOS u ON p.ID_PROFESION_PK = u.ID_PROFESION_FK GROUP BY p.NOMBRE_PROFESION ORDER BY CANTIDAD;";
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
    public function obtenerUsuariosPorEstado()
    {
        $SQL = "SELECT e.NOMBRE_ESTADO, COUNT(*) AS CANTIDAD FROM ESTADOS e JOIN USUARIOS u ON e.ID_ESTADO_PK = u.ID_ESTADO_FK GROUP BY e.NOMBRE_ESTADO ORDER BY CANTIDAD;";
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


    public function obtenerPublicacionesPorCategoria()
    {
        $SQL = "SELECT C.NOMBRE_CATEGORIA, COUNT(P.ID_PUBLICACION_PK) AS CANTIDAD FROM PUBLICACIONES P INNER JOIN CATEGORIAS C ON P.ID_CATEGORIA_FK = C.ID_CATEGORIA_PK GROUP BY C.NOMBRE_CATEGORIA ORDER BY CANTIDAD;";
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
    }*/
}
?>