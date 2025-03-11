<?php
session_start();
require_once '../config/Conexion.php';

class User extends Conexion
{
    protected static $conn;
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

    //----------------Métodos-----------------

    public static function getConexion()
    {
        self::$conn = Conexion::conectar();
    }

    public static function desconectar()
    {
        self::$conn = null;
    }

    public function insertarUsuario()
    {
        $SQL = "INSERT INTO USUARIOS(ID_ROL_FK, ID_PROFESION_FK, CEDULA_USUARIO, NOMBRE_USUARIO, APELLIDO1, APELLIDO2, EDAD, DIRECCION, TELEFONO, EMAIL, CONTRASENA, IMAGEN_URL)
                values (?,?,?,?,?,?,?,?,?,?,?,?)";

        try {
            self::getConexion();
            $res = self::$conn->prepare($SQL);
            $res->bindParam(1, $this->idRol);
            $res->bindParam(2, $this->idProfesion);
            $res->bindParam(3, $this->cedula);
            $res->bindParam(4, $this->nombre);
            $res->bindParam(5, $this->apellido1);
            $res->bindParam(6, $this->apellido2);
            $res->bindParam(7, $this->edad);
            $res->bindParam(8, $this->direccion);
            $res->bindParam(9, $this->telefono);
            $res->bindParam(10, $this->email);
            $res->bindParam(11, $this->contrasena);
            $res->bindParam(12, $this->imagen_url);

            $res->execute();
            self::desconectar();
            return true;
        } catch (PDOException $Exception) {
            self::desconectar(); //Esto lo robe del ejemplo crud
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return false;
        }
    }

    public function iniciarSesion2($email, $contrasena)
    {
        $SQL = "SELECT ID_USUARIO_PK,NOMBRE_ROL,NOMBRE_ESTADO,NOMBRE_PROFESION,CEDULA_USUARIO,NOMBRE_USUARIO,APELLIDO1,APELLIDO2,
                EDAD,DIRECCION,TELEFONO,EMAIL,FACEBOOK,INSTAGRAM,FECHA_REGISTRO,IMAGEN_URL 
                FROM USUARIOS U 
                INNER JOIN ROLES R  ON U.ID_ROL_FK = R.ID_ROL_PK
                INNER JOIN ESTADOS E ON U.ID_ESTADO_FK = E.ID_ESTADO_PK
                INNER JOIN PROFESIONES P ON U.ID_PROFESION_FK = P.ID_PROFESION_PK
                WHERE EMAIL = ? AND CONTRASENA = ?;";
        try {
            self::getConexion();
            $res = self::$conn->prepare($SQL);
            $res->bindParam(1, $email);
            $res->bindParam(2, $contrasena);
            $res->execute();
            self::desconectar();
            $res = $res->fetch();

            if ($res) {
                $_SESSION['usuario'] =
                    [
                        'idUsuario' => $res['ID_USUARIO_PK'],
                        'nombreRol' => $res['NOMBRE_ROL'],
                        'nombreEstado' => $res['NOMBRE_ESTADO'],
                        'nombreProfesion' => $res['NOMBRE_PROFESION'],
                        'cedula' => $res['CEDULA_USUARIO'],
                        'nombre' => $res['NOMBRE_USUARIO'],
                        'apellido1' => $res['APELLIDO1'],
                        'apellido2' => $res['APELLIDO2'],
                        'edad' => $res['EDAD'],
                        'direccion' => $res['DIRECCION'],
                        'telefono' => $res['TELEFONO'],
                        'email' => $res['EMAIL'],
                        'facebook' => $res['FACEBOOK'],
                        'instagram' => $res['INSTAGRAM'],
                        'fecha_registro' => $res['FECHA_REGISTRO'],
                        'imagen_url' => $res['IMAGEN_URL']
                    ];
                return true;
            }
            return false;
        } catch (PDOException $Exception) {
            self::desconectar(); //Esto lo robe del ejemplo crud
            error_log("Error " . $Exception->getCode() . ": " . $Exception->getMessage());
            return false;
        }
    }

    public function obtenerProfesiones()
    {
        $SQL = "SELECT * FROM PROFESIONES";
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

    public function insertarRedes()
    {
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

    public function verificarExistenciaDb($id)
    {
        $query = "SELECT * FROM usuarios where ID_USUARIO_PK=?";
        try {
            self::getConexion();
            $resultado = self::$conn->prepare($query);
            //$id= $this->getId();	
            //$resultado->bindParam(":ID_USUARIO_PK",$id,PDO::PARAM_INT);
            $resultado->bindParam(1, $id);
            $resultado->execute();
            self::desconectar();
            //var_dump($resultado->fetchAll());
            $encontrado = false;


            $nombre = $resultado->fetch();
            if ($nombre != null) {
                $encontrado = true;
                //var_dump($nombre);
            }
            //foreach ($resultado->fetchAll() as $reg) {
            //var_dump($encontrado);
            //$encontrado = true;
            //}
            return $encontrado;
        } catch (PDOException $Exception) {
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return $error;
        }
    }


    public function modificarUsuario() {
        $query = "UPDATE usuarios 
                  SET NOMBRE_USUARIO = :NOMBRE_USUARIO, 
                      ID_PROFESION_FK = :ID_PROFESION_FK, 
                      DIRECCION = :DIRECCION,
                      TELEFONO = :TELEFONO,  
                      EMAIL = :EMAIL, 
                      INSTAGRAM = :INSTAGRAM,
                      FACEBOOK = :FACEBOOK,
                      CEDULA_USUARIO = :CEDULA_USUARIO,
                      IMAGEN_URL = :IMAGEN_URL
                  WHERE ID_USUARIO_PK = :ID_USUARIO_PK";
    
        try {
            self::getConexion();
            $id = $this->getId();
            $nombre = $this->getNombre();
            $direccion = $this->getDireccion();
            $telefono = $this->getTelefono();
            $email = $this->getEmail();
            $instagram = $this->getInstagram();
            $facebook = $this->getFacebook();
            $cedula = $this->getCedula();
            $imagen_url = $this->getImagenUrl();
            $profesion = $this->getIdProfesion();
    
            $resultado = self::$conn->prepare($query);
            $resultado->bindParam(":ID_USUARIO_PK", $id, PDO::PARAM_INT);
            $resultado->bindParam(":NOMBRE_USUARIO", $nombre, PDO::PARAM_STR);
            $resultado->bindParam(":DIRECCION", $direccion, PDO::PARAM_STR);
            $resultado->bindParam(":TELEFONO", $telefono, PDO::PARAM_STR);
            $resultado->bindParam(":EMAIL", $email, PDO::PARAM_STR);
            $resultado->bindParam(":INSTAGRAM", $instagram, PDO::PARAM_STR);
            $resultado->bindParam(":FACEBOOK", $facebook, PDO::PARAM_STR);
            $resultado->bindParam(":CEDULA_USUARIO", $cedula, PDO::PARAM_INT);
            $resultado->bindParam(":IMAGEN_URL", $imagen_url, PDO::PARAM_STR);
            $resultado->bindParam(":ID_PROFESION_FK", $profesion, PDO::PARAM_INT);
    
            self::$conn->beginTransaction();
            $resultado->execute();
            self::$conn->commit();
            self::desconectar();
    
            return $resultado->rowCount();
        } catch (PDOException $Exception) {
            self::$conn->rollBack();
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return $error;
        }
    }

    



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //aqui pintamos los graficos 

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
    }
}



//codigo para probar que el modelo pinte los datos
//$usuario = new User();
//$resultado = $usuario->obtenerUsuariosPorProfesion();

//if (is_array($resultado)) {
//foreach ($resultado as $fila) {
// echo "NOMBRE_PROFESION: " . $fila['NOMBRE_PROFESION'] . " - CANTIDAD: " . $fila['CANTIDAD'] . PHP_EOL;
// }
//} else {
//   echo "Error: " . $resultado;
//}

//$r = new User();
//$r-> setFacebook("marcos33") ;
//$r-> setInstagram("marco67");
//$r-> setId($_SESSION['usuario']['idUsuario']);
//var_dump($r->getInstagram());
//var_dump($r->getFacebook());
//var_dump($r->getId());
//var_dump($r->getInstagram());
//var_dump($r->insertarRedes());
?>