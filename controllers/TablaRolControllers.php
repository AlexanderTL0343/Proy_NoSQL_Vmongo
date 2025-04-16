<?php
include '../models/TablaRol.php';


switch ($_GET['op']) {
 case 'LlenarTablaRol':
    $tabla = new TablaRol();
    echo json_encode($tabla->listarTablaRol());
    break;

}
?>
