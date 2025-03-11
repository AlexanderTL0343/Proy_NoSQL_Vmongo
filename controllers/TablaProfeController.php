<?php
include '../models/TablaProfesiones.php';


switch ($_GET['op']) {
    case 'LlenarTablaProfe':
        $tabla = new TablaProfe();
        $clientes = $tabla->listarTablaProfe();
        $data = array();
        foreach ($clientes as $reg) {
            $data[] = array(
                "0" => $reg->getIdProfesionPk(),
                "1" => $reg->getNombreProfesion(),
                "2" => '<button class="btn btn-warning" id="modificarProfesion">Modificar</button>  ' .
                    '<button class="btn btn-danger" id="eliminarProfesion">Eliminar</button> '
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

    case 'insertar':
        $id = isset($_POST["Fid"]) ? trim($_POST["Fid"]) : "";
        $nombre = isset($_POST["Fnombre"]) ? trim($_POST["Fnombre"]) : "";
        $tabla = new TablaProfe();
        $tabla->setIdProfesionPk($id);
        $encontrado = $tabla->verificarExistenciaDb($id);
        if ($encontrado == false) {
            $tabla->setIdProfesionPk($id);
            $tabla->setNombreProfesion($nombre);
            $tabla->guardarProfesion();
            if ($tabla->verificarExistenciaDb($id)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 2;
        }
        break;

    case 'editar':
        $id = isset($_POST["Mid"]) ? trim($_POST["Mid"]) : "";
        $nombre = isset($_POST["Mnombre"]) ? trim($_POST["Mnombre"]) : "";

        $tabla = new TablaProfe();

        $encontrado = $tabla->verificarExistenciaDb($id);

        if ($encontrado == 1) {
            $tabla->llenarCampos($id);
            $tabla->setNombreProfesion($nombre);

            $modificados = $tabla->actualizarProfesion();
            if ($modificados > 0) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            print_r("ERROR DE CONTROLADOR");

            echo 2;
        }
        break;
}
