<?php

    //ESTO ES PARA AHORRA LINEAS EN LAS OTRAS VIEWS, AQUI SE MUESTRA UN HEADER DEPENDIENDO DEL ROL
    //PARA ASI EN VEZ DE CAMBIAR TODOS, SOLO SE CAMBIA 1

    if (!isset($_SESSION['usuario'])) {
        // Redirige al login si no hay sesión activa
        include("./assets/fragmentos/header.php");

    } elseif ($_SESSION['usuario']['nombreRol'] === 'ADMIN') {//donde dice [usuario] es la variable de sesion, esta variable almacena un arreglo asociativo
        include("./assets/fragmentos/header_admin.php");      //[nombreRol] es la llave en el arreglo, es deci (llave=>valor), entonces buscamos el valor de nombreRol
    } elseif ($_SESSION['usuario']['nombreRol'] === 'RECLUTADOR') {
        include("./assets/fragmentos/header_reclutador.php");
    } elseif ($_SESSION['usuario']['nombreRol'] === 'POSTULANTE') {
        include("./assets/fragmentos/header_postulante.php");
    } elseif ($_SESSION['usuario']['nombreRol'] === '') {
        include("./assets/fragmentos/header.php");
    }
?>