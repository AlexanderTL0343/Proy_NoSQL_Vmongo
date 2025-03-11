<?php
include '../models/TablaPublicaciones.php';

switch ($_GET['op']) {

    case 'LlenarTablaPubli':
                $tabla = new TablaPubli();
                $clientes = $tabla->listarTablaPubli();
                $data = array();
                foreach ($clientes as $reg) {
                    $data[] = array(
                        "0" => $reg->getIdPublicacionesPk(),
                        "1" => $reg->getIdUsuarioFk(),
                        "2" => $reg->getTituloPublicacion(),
                        "3" => $reg->getDescripcion(),
                        "4" => $reg->getFechaPublicacion(),
                        "5" => $reg->getUbicacion(),
                        "6" => $reg->getPrecioAprox(),
                        "7" => $reg->getEstado(),
                        "8" => '<button class="btn btn-warning" id="modificarPubli">Modificar</button>  '.
                                '<button class="btn btn-danger" id="eliminarPubli">Eliminar</button> '
                    );
                }
                $resultados = array(
                    "sEcho" => 1,
                    "iTotalRecords" => count($data),
                    "iTotalDisplayRecords" => count($data),
                    "aaData" => $data
                );
                echo json_encode($resultados);
                break;
            
    case 'editar':
                $id = isset($_POST["Pid"]) ? trim($_POST["Pid"]) : "";
    
                $usuario = isset($_POST["Puser"]) ? trim($_POST["Puser"]) : "";
                $titulo = isset($_POST["Ptitulo"]) ? trim($_POST["Ptitulo"]) : "";
                $descripcion = isset($_POST["Pdescripcion"]) ? trim($_POST["Pdescripcion"]) : "";
                $ubicacion = isset($_POST["Pubicacion"]) ? trim($_POST["Pubicacion"]) : "";
                $precio = isset($_POST["Pprecio"]) ? trim($_POST["Pprecio"]) : "";
            
                $publicacion = new TablaPubli();
    
                $encontrado = $publicacion->verificarExistenciaDb($id);
    
                if ($encontrado == 1) {
                    $publicacion->llenarCampos($id);
                    $publicacion->setIdUsuarioFk($usuario);
                    $publicacion->setTituloPublicacion($titulo);
                    $publicacion->setDescripcion($descripcion);
                    $publicacion->setUbicacion($ubicacion);
                    $publicacion->setPrecioAprox($precio);
            
                    $modificados = $publicacion->actualizarPublicaciones();
                    if ($modificados > 0) {
                        echo 1;
                    } else {
                        echo 0;
                    }
                } else {
    
                    echo 2; 
                }
            break;
            }
?>