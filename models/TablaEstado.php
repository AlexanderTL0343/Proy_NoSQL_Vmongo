<?php
    session_start();
    require_once '../config/ConexionAtlas.php';

    class TablaEstados extends ConexionAtlas
    {

        protected static $cnx;
        private $idEstadoPk;
        private $nombreEstado;
        private $descripcion;

        public function __construct() {}

        //Metodos de conexion y desconexion 

        public static function getConexion()
        {
            self::$cnx = ConexionAtlas::conectar();
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
            try{
                $db = ConexionAtlas::conectar();

                $res = $db->ESTADOS->find();

                $resArray = iterator_to_array($res);

                $data = [];

                foreach ($resArray as $estado) {
                    $data[] = [
                        (string)$estado['_id'],
                        $estado['estado'] ?? ''
        
                    ];
                } 
                 return[
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                ];

            }catch (MongoDB\Driver\Exception\Exception $Exception) {
                return [
                    'error' => "Error " . $Exception->getCode() . ": " . $Exception->getMessage()
                ];
            }
        }
    }
