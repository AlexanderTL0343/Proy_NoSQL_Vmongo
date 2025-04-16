<?php
include '../models/TablaUser.php';

switch ($_GET['op']) {
    case 'LlenarTablaUser':
        
        $tabla = new TablaUser();
        echo json_encode($tabla->listarTablaUser());
        break;
      
    case 'editar':
        $id = isset($_POST["Eid"]) ? trim($_POST["Eid"]) : "";

        $email = isset($_POST["Eemail"]) ? trim($_POST["Eemail"]) : "";
        $nombre = isset($_POST["Enombre"]) ? trim($_POST["Enombre"]) : "";
        $edad = isset($_POST["Eedad"]) ? trim($_POST["Eedad"]) : "";
        $profesion = isset($_POST["Eprofesion"]) ? trim($_POST["Eprofesion"]) : "";
        $rol = isset($_POST["Erol"]) ? trim($_POST["Erol"]) : "";

        $usuario = new TablaUser();

        $encontrado = $usuario->verificarExistenciaDb($id);

        if ($encontrado == 1) {
            $usuario->llenarCampos($id);
            $usuario->setNombre($nombre);
            $usuario->setEdad($edad);
            $usuario->setProfesion($profesion);
            $usuario->setIdRol($rol);
            $usuario->setEmail($email);

            $modificados = $usuario->actualizarUsuario();
            if ($modificados > 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            //print_r("ERROR DE CONTROLADOR");

            echo 2;
        }
        break;
    case 'eliminar':

        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        error_log("Datos enviados al controlador: " . print_r($_POST, true)); // Ver todos los datos enviados
        error_log("ID recibido para eliminar: " . $id);

        if ($id === '') {
            error_log("Error: ID de usuario no proporcionado.");
            echo json_encode(['status' => 'error', 'message' => 'ID de usuario no proporcionado.']);
            break;
        }
        $usuario = new TablaUser();

        $encontrado = $usuario->verificarExistenciaDb($id);
        error_log("Resultado de verificarExistenciaDb: " . ($encontrado ? "Usuario encontrado" : "Usuario no encontrado"));

        if ($encontrado) {
            $eliminado = $usuario->eliminarUsuario($id);

            if ($eliminado > 0) {
                error_log("Usuario con ID $id eliminado exitosamente.");
                echo json_encode(['status' => 'success', 'message' => 'Usuario eliminado exitosamente.']);
            } else {
                error_log("Error: No se pudo eliminar el usuario con ID $id.");
                echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el usuario.']);
            }
        } else {
            error_log("Error: Usuario con ID $id no encontrado en la base de datos.");
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado.']);
        }
        break;
}
///
