<?php
include '../models/TablaEstado.php';


switch ($_GET['op']) {
 case 'LlenarTablaEstado':
    $tabla = new TablaEstados();
    echo json_encode($tabla->listarTablaEstados());
    break;
}
//
?>