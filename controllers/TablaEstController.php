<?php
include '../models/TablaEstado.php';


switch ($_GET['op']) {
 case 'LlenarTablaEstado':
    $tabla = new TablaEstados();
    $clientes = $tabla->listarTablaEstados();
    $data = array();
    foreach ($clientes as $reg) {
        $data[] = array(
            "0" => $reg->getIdEstadoPk(),
            "1" => $reg->getNombreEstado(),
            "2" => $reg->getDescripcion(),
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