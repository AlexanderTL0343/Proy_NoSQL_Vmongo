<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<?php
include("./assets/fragmentos/sinSesion401.php");
include("./assets/fragmentos/head.php");
?>

<body>
  <?php include("../config/session.php"); ?> <!--PARA COLOCAR EL HEADER DEPENDIENDO DEL ROL-->

  <section class="d-flex flex-fill align-items-center justify-content-center ">
    <form class="w-25" id="editaruser">
      <div class="form-group mb-4">
        <label for="imagen">Imagen:</label>
        <input name="imagen" type="file" class="form-control" id="imagen" />
        <p class="text-danger"></p>
      </div>

      <div class="form-group mb-4">
        <label for="nombre">Nombre:</label>
        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre" required />
        <p class="text-danger"></p>
      </div>

      </div>
      <div class="form-group mb-4">
                    <label for="profesion">Profesión:</label>
                    <select name="profesion" class="form-control" id="profesion" required>
                        <option value="">Seleccione una Profesión</option>
                    </select>
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
        <label for="email">Email:</label>
        <input name="email" type="email" class="form-control" id="email" placeholder="Ingrese su Email" required />
        <p class="text-danger"></p>
      </div>
      <div class="form-group mb-4">
        <label for="instagram">Instagram:</label>
        <input name="instagram" type="text" class="form-control" id="instagram" placeholder="Ingrese su instagram" required />
        <p class="text-danger"></p>
      </div>
      <div class="form-group mb-4">
        <label for="direccion">Facebook:</label>
        <input name="facebook" type="text" class="form-control" id="facebook" placeholder="Ingrese su Facebook" required />
        <p class="text-danger"></p>
      </div>

      <button id= "EditarUser" type="submit"  class="btn btn-primary">Guardar</button>
    </form>
  </section>
  <?php include("./assets/fragmentos/footer.php"); ?>
</body>
<?php include("./assets/fragmentos/scripts.php"); ?>
<script src="plugins/bootbox/bootbox.min.js"></script>
<script src="./assets/js/index.js"></script>

</html>