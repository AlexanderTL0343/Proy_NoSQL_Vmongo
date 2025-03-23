<?php
    session_start();
    require_once '../models/publicacionesModel.php';

    switch ($_GET['op']) {
        case 'insertarPublicacion':
            $publicacion = new publicacion();
            $publicacion->setTituloPublicacion(isset($_POST['titulo_publicacion']) ? trim($_POST['titulo_publicacion']) : "");
            $publicacion->setDescripcion(isset($_POST['descripcion']) ? trim($_POST['descripcion']) : "");
            $publicacion->setPrecioAprox(isset($_POST['precio_aprox']) ? trim($_POST['precio_aprox']) : 0);
            $publicacion->setCiudad(isset($_POST['ciudad']) ? trim($_POST['ciudad']) : "");
            $publicacion->setProvincia(isset($_POST['provincia']) ? trim($_POST['provincia']) : "");
            $publicacion->setDireccion(isset($_POST['direccion']) ? trim($_POST['direccion']) : "");
            $publicacion->setIdCategoria(isset($_POST['categoria']) ? trim($_POST['categoria']) : 0);
            $publicacion->setImagenUrl(isset($_POST['imagen_url']) ? trim($_POST['imagen_url']) : "");
            $publicacion->setIdEstado(isset($_POST['id_estado_fk']) ? trim($_POST['id_estado_fk']) : 1);
            $publicacion->setIdUsuario($_SESSION['usuario']['idUsuario']);

            if ($publicacion->insertarPublicacion() == true) {
                $response = array();
                $response = [
                    "status" => true,
                    "message" => "Publicación creada exitosamente"
                ];
                echo json_encode($response);
            } else {
                $response = array();
                $response = [
                    "status" => false,
                    "message" => "Error al crear la publicación"
                ];
                echo json_encode($response);
            }
            break;

        case 'listarPublicaciones':
            $publicacion = new publicacion();
            $res = $publicacion->listarPublicaciones();

            //$response = array();
            $response = [
                "status" => true,
                "message" => "Publicaciones obtenidas",
                "datos" => $res
            ];

            echo json_encode($response);
            break;
            
        case "listarCategorias":
            $publicacion = new publicacion();
            $res = $publicacion->listarCategorias();

            //$response = array();
            $response = [
                "status" => true,
                "message" => "Categorias obtenidas",
                "datos" => $res
            ];

            echo json_encode($response);
            break;
        case "actualizarPublicacion":
            /*$publicacion = new publicacion();
            $res = $publicacion->actualizarPublicacion();

            //$response = array();
            $response = [
                "status" => true,
                "message" => "Publicaciones obtenidas",
                "datos" => $res
            ];

            echo json_encode($response);
            break;*/
        case 'eliminarPublicacion':
            $publicacion = new publicacion();
            $res = $publicacion->eliminarPublicacion($_POST['id']);

            //$response = array();
            $response = [
                "status" => true,
                "message" => "Publicación eliminada"
            ];

            echo json_encode($response);
            break;

        case 'obtenerPublicacion':
            $publicacion = new publicacion();
            $res = $publicacion->obtenerPublicacion($_GET['id']);

            //$response = array();
            $response = [
                "status" => true,
                "message" => "Publicación obtenida",
                "datos" => $res
            ];

            echo json_encode($response);
            break;
    }
?>