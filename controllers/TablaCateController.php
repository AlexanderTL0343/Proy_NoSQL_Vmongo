<?php
include '../models/TablaCategorias.php';


switch ($_GET['op']) {
    case 'LlenarTablaCate':
        $tabla = new TablaCate();
        echo json_encode($tabla->listarTablaCate());
        break;
        
    case 'insertar':
        $id = isset($_POST["Cid"]) ? trim($_POST["Cid"]) : "";
        $nombre = isset($_POST["Cnombre"]) ? trim($_POST["Cnombre"]) : "";
        $descripcion = isset($_POST["Cdescripcion"]) ? trim($_POST["Cdescripcion"]) : "";
        $tabla = new TablaCate();
        $tabla->setIdCategoriaPk($id);
        $encontrado = $tabla->verificarExistenciaDb($id);
        if ($encontrado == false) {
            $tabla->setIdCategoriaPk($id);
            $tabla->setNombreCategoria($nombre);
            $tabla->setDescripcion($descripcion);
            $tabla->guardarCategoria();
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
        $id = isset($_POST["CMid"]) ? trim($_POST["CMid"]) : "";
        $nombre = isset($_POST["CMnombre"]) ? trim($_POST["CMnombre"]) : "";
        $descripcion = isset($_POST["CMdescripcion"]) ? trim($_POST["CMdescripcion"]) : "";

        $tabla = new TablaCate();

        $encontrado = $tabla->verificarExistenciaDb($id);

        if ($encontrado == 1) {
            $tabla->llenarCampos($id);
            $tabla->setNombreCategoria($nombre);
            $tabla->setDescripcion($descripcion);

            $modificados = $tabla->actualizarCategoria();
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
