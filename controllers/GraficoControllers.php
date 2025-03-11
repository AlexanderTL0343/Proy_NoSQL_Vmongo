<?php
require_once '../models/UserModel.php';

switch ($_GET['op']) {
    case 'getUsuariosPorRol':
        $usuario = new User();
        $datos = $usuario->obtenerDatosGraficos();
        echo json_encode($datos);
        break;

    case 'getUsuariosPorEdad':
        $usuario = new User();
        $datos = $usuario->obtenerUsuariosPorEdad();

        echo json_encode($datos);
        break;


    case 'getProfesionPorUsuario':
        $usuario = new User();
        $datos = $usuario->obtenerUsuariosPorProfesion();

        echo json_encode($datos);
        break;

    case 'getEstadoPorUsuario':
        $usuario = new User();
        $datos = $usuario->obtenerUsuariosPorEstado();

        echo json_encode($datos);
        break;

        case 'getPubliPorCate':
            $usuario = new User();
            $datos = $usuario->obtenerPublicacionesPorCategoria();
    
            echo json_encode($datos);
            break;
}
