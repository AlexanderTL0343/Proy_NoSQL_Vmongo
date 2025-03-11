<?php
    session_start();
    require_once '../models/publicacionesModel.php';

    switch ($_GET['op']) {
        case 'insertarPublicacion':
            $publicacion = new publicacion();
            $publicacion->setIdCategoria(isset($_POST['categoria']) ? trim($_POST['categoria']) : 0);
            $publicacion->setTituloPublicacion(isset($_POST['titulo']) ? trim($_POST['titulo']) : "");
            $publicacion->setDescripcion(isset($_POST['descripcion']) ? trim($_POST['descripcion']) : "");
            $publicacion->setIdUsuario($_SESSION['usuario']['idUsuario']);
            $publicacion->setUbicacion(isset($_POST['ubicacion']) ? trim($_POST['ubicacion']) : "");
            $publicacion->setPrecioAprox(isset($_POST['precio']) ? trim($_POST['precio']) : 0);

            if ($publicacion->insertarPublicacion() == true) {
                $response = array();
                $response[] = [
                    "status" => true,
                    "message" => "Publicación creada exitosamente"
                ];
                echo json_encode($response);
            } else {
                $response = array();
                $response[] = [
                    "status" => false,
                    "message" => "Error al crear la publicación"
                ];
                echo json_encode($response);
            }
            break;

        case 'listarPublicaciones':
            $publicacion = new publicacion();
            $res = $publicacion->listarPublicaciones();

            $response = array();
            $response[] = [
                "status" => true,
                "message" => "Publicaciones obtenidas",
                "datos" => $res
            ];

            echo json_encode($response);
            break;
    }


    // Obtener publicación
if ($_GET['op'] == 'obtenerPublicacion') {
    $id = $_GET['id'];
    $publicacion = $publicaciones->obtenerPublicacionPorId($id);
    echo json_encode($publicacion);
}

// Actualizar publicación
if ($_POST['op'] == 'actualizarPublicacion') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ubicacion = $_POST['ubicacion'];
    $precio = $_POST['precio'];
    $publicaciones->actualizarPublicacion($id, $titulo, $descripcion, $ubicacion, $precio);
    echo json_encode(["status" => "success"]);
}

// Eliminar publicación
if ($_POST['op'] == 'eliminarPublicacion') {
    $id = $_POST['id'];
    $publicaciones->eliminarPublicacion($id);
    echo json_encode(["status" => "success"]);
}

?>