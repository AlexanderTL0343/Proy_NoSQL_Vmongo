<?php
session_start();
require_once '../config/Conexion.php';

class TablaUser extends Conexion
{

    protected static $cnx;
    private $id;
    private $idRol;
    private $cedula;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $profesion;
    private $edad;
    private $direccion;
    private $telefono;
    private $estado;
    private $email;
    private $contrasena;
    private $facebook;
    private $instagram;
    private $fecha_registro;
    private $imagen_url;

    public function __construct() {}

    //Metodos de conexion y desconexion 

    public static function getConexion()
    {
        self::$cnx = Conexion::conectar();
    }

    public static function desconectar()
    {
        self::$cnx = null;
    }

    // metodos set y get 

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

    public function getProfesion()
    {
        return $this->profesion;
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

    public function getEstado()
    {
        return $this->estado;
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

    public function setProfesion($profesion)
    {
        $this->profesion = $profesion;
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

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    //funcion para listar la tabla de los usuarios 

    public function listarTablaUser()
    {
        $query = "SELECT u.ID_USUARIO_PK, u.NOMBRE_USUARIO, u.EDAD, u.EMAIL, p.NOMBRE_PROFESION, u.FECHA_REGISTRO, r.NOMBRE_ROL, e.NOMBRE_ESTADO
          FROM usuarios u 
          JOIN roles r ON u.ID_ROL_FK = r.ID_ROL_PK 
          JOIN profesiones p ON u.ID_PROFESION_FK = p.ID_PROFESION_PK
          JOIN estados e  ON u.ID_ESTADO_FK = e.ID_ESTADO_PK";

        $arr = array();
        try {
            self::getConexion();

            $resultado = self::$cnx->prepare($query);
            $resultado->execute();
            self::desconectar();
            foreach ($resultado->fetchAll() as $encontrado) {
                $client = new TablaUser();
                $client->setId($encontrado['ID_USUARIO_PK']);
                $client->setNombre($encontrado['NOMBRE_USUARIO']);
                $client->setEdad($encontrado['EDAD']);
                $client->setEmail($encontrado['EMAIL']);
                $client->setProfesion($encontrado['NOMBRE_PROFESION']);
                $client->setFechaRegistro($encontrado['FECHA_REGISTRO']);
                $client->setIdRol($encontrado['NOMBRE_ROL']);
                $client->setEstado($encontrado['NOMBRE_ESTADO']);
                $arr[] = $client;
            }
            return $arr;
        } catch (PDOException $Exception) {
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
            return json_encode($error);
        }
    }


    public function verificarExistenciaDb($id)
    {
        $query = "SELECT * FROM usuarios where ID_USUARIO_PK=?";
        try {
            self::getConexion();
            $resultado = self::$cnx->prepare($query);
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

    public function llenarCampos($id)
    {
        $query = "SELECT * FROM usuarios where ID_USUARIO_PK=:ID_USUARIO_PK";
        try {
            self::getConexion();
            $resultado = self::$cnx->prepare($query);
            $resultado->bindParam(":ID_USUARIO_PK", $id, PDO::PARAM_INT);
            $resultado->execute();
            self::desconectar();
            foreach ($resultado->fetchAll() as $encontrado) {
                $this->setId($encontrado['ID_USUARIO_PK']);
                $this->setNombre($encontrado['NOMBRE_USUARIO']);
            }
        } catch (PDOException $Exception) {
            self::desconectar();
            $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();;
            return json_encode($error);
        }
    }

    public function actualizarUsuario()
    {
        $query = "UPDATE usuarios 
            SET NOMBRE_USUARIO = :NOMBRE_USUARIO, 
                EDAD = :EDAD, 
                EMAIL = :EMAIL, 
                ID_PROFESION_FK = :ID_PROFESION_FK, 
                ID_ROL_FK = :ID_ROL_FK
            WHERE ID_USUARIO_PK = :ID_USUARIO_PK";
        try {
            self::getConexion();
            $id = $this->getId();
            $nombre = $this->getNombre();
            $edad = $this->getEdad();
            $email = $this->getEmail();
            $profesion = $this->getProfesion();
            $rol = $this->getIdRol();

            $resultado = self::$cnx->prepare($query);
            $resultado->bindParam(":ID_USUARIO_PK", $id, PDO::PARAM_INT);
            $resultado->bindParam(":NOMBRE_USUARIO", $nombre, PDO::PARAM_STR);
            $resultado->bindParam(":EDAD", $edad, PDO::PARAM_INT);
            $resultado->bindParam(":EMAIL", $email, PDO::PARAM_STR);
            $resultado->bindParam(":ID_PROFESION_FK", $profesion, PDO::PARAM_INT);
            $resultado->bindParam(":ID_ROL_FK", $rol, PDO::PARAM_INT);

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

//$mode = new Tablauser();
//var_dump($mode->verificarExistenciaDb(1));
