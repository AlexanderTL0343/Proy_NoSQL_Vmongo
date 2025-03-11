<?php
include '../models/TablaRol.php';


switch ($_GET['op']) {
 case 'LlenarTablaRol':
    $tabla = new TablaRol();
    $clientes = $tabla->listarTablaRol();
    $data = array();
    foreach ($clientes as $reg) {
        $data[] = array(
            "0" => $reg->getIdRolPk(),
            "1" => $reg->getNombreRol(),
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

}
?>
