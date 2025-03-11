<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<?php include("./assets/fragmentos/head.php"); ?>

<body>

    <?php include("../config/session.php"); ?> <!--PARA COLOCAR EL HEADER DEPENDIENDO DEL ROL-->

    <section class=" py-5 d-flex flex-column justify-content-center align-items-center">
        <div class="p-5 lc-block shadow rounded-3 bg-white">
            <h3 class="card-title text-center mb-4 font-weight-bold fs-3">Regístrate para acceder a nuestros servicios:</h3>

            <form class="form-horizontal" id="registroUsuario" method="POST" enctype="multipart/form-data">

                <div class="d-flex justify-content-around mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoUsuario" id="radioPostulante" value="2" required><!---valor 2 para indicar el id de POSTULANTE para la bsd-->
                        <label class="form-check-label" for="radioPostulante">
                            Postulante
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipoUsuario" id="radioReclutador" value="3" required><!---valor 3 para indicar el id de Rclutador para la bsd-->
                        <label class="form-check-label" for="radioReclutador">
                            Reclutador
                        </label>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="cedula">Cédula:</label>
                    <input name="cedula" type="number" class="form-control" id="cedula" placeholder="Ingrese su cédula" required />
                    <p class="text-danger"></p>
                </div>

                <div class="row">
                    <div class="form-group col mb-4">
                        <label for="nombre">Nombre:</label>
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Ingrese su Nombre" required />
                        <p class="text-danger"></p>
                    </div>

                    <div class="form-group col mb-4">
                        <label for="apellido1">Primer Apellido:</label>
                        <input name="apellido1" type="text" class="form-control" id="apellido1" placeholder="Primer Apellido" required />
                        <p class="text-danger"></p>
                    </div>
                    <div class="form-group col mb-4">
                        <label for="apellido2">Segundo Apellido:</label>
                        <input name="apellido2" type="text" class="form-control" id="apellido2" placeholder="Segundo Apellido" required />
                        <p class="text-danger"></p>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="edad">Edad:</label>
                    <input name="edad" type="number" class="form-control" id="edad" placeholder="Ingrese su edad" min="16" max="150" required />
                    <p class="text-danger"></p>
                </div>

                <div class="form-group mb-4">
                    <label for="profesion">Profesión:</label>
                    <select name="profesion" class="form-control" id="profesion" required>
                        <option value="">Seleccione una Profesión</option>
                        <!--<option value="Ingeniero">Especialista en Tecnología</option>
                        <option value="Arquitecto">Profesional Jurídico</option>
                        <option value="Profesiona-de-la-Salud">Profesional de la Salud</option>
                        <option value="Ingeniero">Ingeniero </option>
                        <option value="Técnico-Especializado">Técnico Especializado</option>
                        <option value="Diseñador">Diseñador</option>
                        <option value="Operador-de-Transporte">Operador de Transporte</option>-->
                    </select>
                    <p class="text-danger"></p>
                </div>

                <div class="form-group mb-4">
                    <label for="email">Email:</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Ingrese su Email" required />
                    <p class="text-danger"></p>
                </div>

                <div class="form-group mb-4">
                    <label for="contrasena">Contraseña:</label>
                    <input name="contrasena" type="password" class="form-control" id="contrasena" placeholder="Ingrese una contraseña" required />
                    <p class="text-danger"></p>
                </div>

                <div class="form-group mb-4">
                    <label for="direccion">Dirección:</label>
                    <input name="direccion" type="text" class="form-control" id="direccion" placeholder="Ingrese su dirección" required />
                    <p class="text-danger"></p>
                </div>

                <div class="form-group mb-4">
                    <label for="telefono">Teléfono:</label>
                    <input name="telefono" type="number" class="form-control" id="telefono" placeholder="Ingrese el número de teléfono" required />
                    <p class="text-danger"></p>
                </div>

                <div class="form-group mb-4">
                    <label for="imagen">Imagen:</label>
                    <input name="imagen" type="file" class="form-control" id="imagen" />
                    <p class="text-danger"></p>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="checkTerminos">
                    <label class="form-check-label" for="checkTerminos">
                        Acepto los <a href="#">Términos y Condiciones</a>
                    </label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" id="botonRegistro" class="btn btn-lg btn-primary" disabled>Registrarse</button>
                </div>
            </form>
        </div>
    </section>

    <?php include("./assets/fragmentos/footer.php"); ?>
</body>
<?php include("./assets/fragmentos/scripts.php"); ?>

</html>