<?php
    if (!isset($_SESSION['usuario'])) {
        header("Location: ../views/401.php");
        exit;
    } 
?>