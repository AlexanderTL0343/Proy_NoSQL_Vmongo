<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<?php
include("./assets/fragmentos/sinSesion401.php");
include("./assets/fragmentos/head.php");
?>

<body>
    <?php include("../config/session.php"); ?>
    <section class="d-flex flex-fill align-items-center justify-content-center ">
        <form class="w-25" method="POST" id="guardarRedes">
            <div class="form-group mb-4">
                <label for="instagram">Instagram:</label>
                <input name="instagram" type="text" class="form-control" id="instagram" placeholder="Ingrese su instagram" required />
                <p class="text-danger"></p>
            </div>
            <div class="form-group mb-4">
                <label for="facebook">Facebook:</label>
                <input name="facebook" type="text" class="form-control" id="facebook" placeholder="Ingrese su Facebook" required />
                <p class="text-danger"></p>
            </div>

            <button type="submit"  id="btnAgregar" class="btn btn-primary">Guardar</button>
        </form>
    </section>
    <?php include("./assets/fragmentos/footer.php"); ?>
</body>
<?php include("./assets/fragmentos/scripts.php"); ?>


</html>