<?php
include '../models/TablaCalificaciones.php';

switch ($_GET['op']) {

case 'LlenarTablaCali':
            $tabla = new TablaCali();
            echo json_encode($tabla->listarTablaCali());
            break;
        }
?>