 <?php
    session_start();
    require_once '../config/Conexion.php';

    class TablaEstados extends Conexion
    {

        protected static $cnx;
        private $idEstadoPk;
        private $nombreEstado;
        private $descripcion;

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

        public  function  getIdEstadoPk()
        {
            return $this->idEstadoPk;
        }

        public  function  getNombreEstado()
        {
            return $this->nombreEstado;
        }
        public  function  getDescripcion()
        {
            return $this->descripcion;
        }


        public function setIdEstadoPk($idEstadoPk)
        {
            $this->idEstadoPk = $idEstadoPk;
        }
        public function setNombreEstado($nombreEstado)
        {
            $this->nombreEstado = $nombreEstado;
        }
        public function setDescripcion($descripcion)
        {
            $this->descripcion = $descripcion;
        }

        public function listarTablaEstados()
        {
            $query = "SELECT * from ESTADOS ";
            $arr = array();
            try {
                self::getConexion();

                $resultado = self::$cnx->prepare($query);
                $resultado->execute();
                self::desconectar();
                foreach ($resultado->fetchAll() as $encontrado) {
                    $client = new TablaEstados();
                    $client->setIdEstadoPk($encontrado['ID_ESTADO_PK']);
                    $client->setNombreEstado($encontrado['NOMBRE_ESTADO']);
                    $client->setDescripcion($encontrado['DESCRIPCION']);
                    $arr[] = $client;
                }
                return $arr;
            } catch (PDOException $Exception) {
                self::desconectar();
                $error = "Error " . $Exception->getCode() . ": " . $Exception->getMessage();
                return json_encode($error);
            }
        }
    }
