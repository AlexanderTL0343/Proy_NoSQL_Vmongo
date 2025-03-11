<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<?php
include("./assets/fragmentos/admin401.php");
include("./assets/fragmentos/head.php");
?>

<body>
    <?php include("../config/session.php"); ?> <!--PARA COLOCAR EL HEADER DEPENDIENDO DEL ROL-->

    <br>

    <div>
        <section class=" py-5 d-flex flex-row wrap justify-content-center align-items-center">
            <p style="justify-content:center align-items-center ;">Distribucion de Roles por usuarios</p>
            <div class="test-reporte w-25 h-25 m-3 bg-light rounded-3 p-2">
                <canvas id="graf-cantidadUsuarios"></canvas>
            </div>
        </section>
    </div>
    <br>

    <div>
        <section class=" py-5 d-flex flex-row wrap justify-content-center align-items-center">
            <p style="justify-content:center align-items-center ;">Recoleccion de Edades por usuarios</p>
            <div class="test-reporte w-25 h-25 m-3 bg-light rounded-3 p-2">
                <canvas id="graf-usuarioPorEdad"></canvas>
            </div>
        </section>
    </div>

    <br>

    <div>
        <section class=" py-5 d-flex flex-row wrap justify-content-center align-items-center">
            <p style="justify-content:center align-items-center ;">Cantidad de Usuarios por Profesion</p>
            <div class="test-reporte w-25 h-25 m-3 bg-light rounded-3 p-2">
                <canvas id="graf-usuarioPorProfe"></canvas>
            </div>
        </section>
    </div>

    <br>

    <div>
        <section class=" py-5 d-flex flex-row wrap justify-content-center align-items-center">
            <p style="justify-content:center align-items-center ;">Cantidad de Usuarios por Estado</p>
            <div class="test-reporte w-25 h-25 m-3 bg-light rounded-3 p-2">
                <canvas id="graf-usuarioPorEstado"></canvas>
            </div>
        </section>
    </div>

    <br>

    <div>
        <section class=" py-5 d-flex flex-row wrap justify-content-center align-items-center">
            <p style="justify-content:center align-items-center ;">Cantidad de Publicaciones por Categoria</p>
            <div class="test-reporte w-25 h-25 m-3 bg-light rounded-3 p-2">
                <canvas id="graf-publiPorCate"></canvas>
            </div>
        </section>
    </div>

    <?php include("./assets/fragmentos/footer.php"); ?>
</body>
<?php include("./assets/fragmentos/scripts.php"); ?>
<script src="./assets/js/reportes.js"></script>

</html>