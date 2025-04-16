<?php
include '../models/TablaPublicaciones.php';

switch ($_GET['op']) {

    case 'LlenarTablaPubli':
                $tabla = new TablaPubli();
                echo json_encode($tabla->listarTablaPubli());
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
