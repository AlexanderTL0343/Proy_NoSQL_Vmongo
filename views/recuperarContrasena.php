<!DOCTYPE html>
<html lang="es">
<?php include("./assets/fragmentos/head.php"); ?>

<body>
    <?php include("../config/session.php"); ?> <!--PARA COLOCAR EL HEADER DEPENDIENDO DEL ROL-->

    <section class="d-flex flex-fill align-items-center justify-content-center">
        <div class="container px-4 py-5 text-center text-lg-start">
            <div class="row gx-lg-5 align-items-center justify-content-center">

                <div class="col-lg-8 mb-5 mb-lg-0">
                    <!-- Título principal -->
                <h2 class="display-3 fw-bold ls-tight">
                    Recuperar contraseña
                </h2>

                <?php 
                $email = isset($_POST['email']) ? urldecode($_POST['email']) : '';
                ?>

                <!-- Formulario de registro -->
                <div class="card mt-5">
                    <div class="card-body py-5 px-md-5">
                        <form id="recContrasena" method="POST">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="newContrasena">Nueva contraseña</label>
                                <input type="password" id="newContrasena" name="newContrasena" class="form-control" placeholder="Contraseña..." required />
                            </div>

                            <input type="hidden" name="emailUsuarioRecuperar" value="<?php echo $email; ?>">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block mb-4">Actualizar contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </section>

    <?php include("./assets/fragmentos/footer.php"); ?>
</body>
<?php include("./assets/fragmentos/scripts.php"); ?>

</html>