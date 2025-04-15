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
            $publicacion->setImagenUrl(isset($_POST['imagenUrl']) ? trim($_POST['imagenUrl']) : "");
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

            $idPublicacion = isset($_POST['id_publicacion']) ? trim($_POST['id_publicacion']) : "";
            $idUsuarioFK = isset($_POST['id_usuario_fk']) ? trim($_POST['id_usuario_fk']) : "";
            $tituloPublicacion = isset($_POST['titulo_publicacion']) ? trim($_POST['titulo_publicacion']) : "";
            $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : "";
            $precioAprox = isset($_POST['precio_aprox']) ? trim($_POST['precio_aprox']) : 0;
            $provincia = isset($_POST['provincia']) ? trim($_POST['provincia']) : "";
            $ciudad = isset($_POST['ciudad']) ? trim($_POST['ciudad']) : "";
            $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : "";
            $idCategoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : 0;
            $imagenUrl = isset($_POST['imagenUrl']) ? trim($_POST['imagenUrl']) : "";//revisar
            $idEstado = isset($_POST['id_estado_fk']) ? trim($_POST['id_estado_fk']) : 1;

            $publicacion = new publicacion();
            $publicacion->setIdPublicacion($idPublicacion);
            $publicacion->setIdUsuario($idUsuarioFK);
            $publicacion->setTituloPublicacion($tituloPublicacion);
            $publicacion->setDescripcion($descripcion);
            $publicacion->setPrecioAprox($precioAprox);
            $publicacion->setProvincia($provincia);
            $publicacion->setCiudad($ciudad);
            $publicacion->setDireccion($direccion);
            $publicacion->setIdCategoria($idCategoria);
            $publicacion->setImagenUrl($imagenUrl);
            $publicacion->setIdEstado($idEstado);
            //LA FECHA NO SE MODIFICARA

            error_log("***Publicacion actualizada***". print_r($publicacion, true));

            $res = $publicacion->actualizarPublicacion();

            if($res){
                $response = [
                    "status" => true,
                    "message" => "Publicación actualizada exitosamente"
                ];
                echo json_encode($response);
            }else{
                $response = [
                    "status" => false,
                    "message" => "Error al actualizar la publicación (model)"
                ];
                echo json_encode($response);
            }

            break;
        case 'eliminarPublicacion':
            $publicacion = new publicacion();
            $pub = $publicacion->obtenerPublicacion($_POST['id']);
            $res = $publicacion->eliminarPublicacion($_POST['id']);
            
            $imagenUrl = $pub['imagen_url'];

            //$response = array();
            $response = [
                "status" => true,
                "message" => "Publicación eliminada",
                "img_url" => $imagenUrl
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