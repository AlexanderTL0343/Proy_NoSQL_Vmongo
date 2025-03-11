<?php
    //ESTO SE AÑADE UNICAMENTE DONDE PUEDE ACCEDER EL ADMIN, YA QUE EVITA QUE LO QUE NO SEA ADMIN ENTRE
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['nombreRol'] !== 'ADMIN') {
        // Redirige al login si no hay sesión activa o si el usuario no es admin
        header("Location: ../views/401.php");
        exit;
    } 
?>