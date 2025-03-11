<?php session_start();?>
<!DOCTYPE html>
<html lang="es">
<?php include("./assets/fragmentos/head.php"); ?>

<body>

<?php include("../config/session.php");?> <!--PARA COLOCAR EL HEADER DEPENDIENDO DEL ROL-->

    <section class="d-flex flex-fill align-items-center justify-content-center">
        <div class="container px-4 py-5 text-center text-lg-start">
            <div class="row gx-lg-5 align-items-center">

                <!-- Título principal -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-3 fw-bold ls-tight">
                        Comienza a destacar <br />
                        <span class="text-primary">tus trabajos</span>
                    </h1>
                </div>

                <!-- Formulario de registro -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body py-5 px-md-5">
                            <form id="login">   
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" placeholder="Email..." required />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="contrasena">Contraseña</label>
                                    <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña..." required />
                                </div>

                                <div class="form-check d-flex justify-content-between mb-4">
                                    <div>
                                        <input class="form-check-input me-2" type="checkbox" value="" id="recordarme" checked />
                                        <label class="form-check-label" for="recordarme">
                                            Recordarme
                                        </label>
                                    </div>
                                    <div>
                                        <a id="olvidasteContrasena" href="#">¿Olvidaste tu contraseña?</a>
                                    </div>
                                </div>



                               <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-block mb-4">Iniciar Sesión</button>
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