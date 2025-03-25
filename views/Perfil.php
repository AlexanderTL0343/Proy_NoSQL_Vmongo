<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<?php include("./assets/fragmentos/head.php"); ?>

<body>
  <?php include("../config/session.php"); ?> <!-- PARA COLOCAR EL HEADER DEPENDIENDO DEL ROL -->

  <section class="d-flex flex-fill align-items-center justify-content-center" style="background-color: #eee;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              <img src=<?php
              //si la varaible de sesion no esta vacia y es distinta de "" mostrara esa imagen si no una default
              if (isset($_SESSION['usuario']['imagen_url']) && $_SESSION['usuario']['imagen_url'] != "") {
                echo $_SESSION['usuario']['imagen_url'] ;
              }else{
                echo "./assets/imgs/DefaultUser.png";
              }
            
              ?> alt="avatar" class="rounded-circle img-fluid" style="width: 150px; height: 150px;  object-fit: cover;">
              <h5 class="my-3"><?php if (isset($_SESSION['usuario']['nombre'])) echo $_SESSION['usuario']['nombre']; ?></h5>
              <p class="text-muted mb-1"><?php if (isset($_SESSION['usuario']['nombreProfesion'])) echo $_SESSION['usuario']['nombreProfesion']; ?></p>
              <p class="text-muted mb-4"><?php if (isset($_SESSION['usuario']['direccion'])) echo $_SESSION['usuario']['direccion']; ?></p>
              <div class="d-flex justify-content-center mb-2">
                <!-- Botón para abrir el modal de edición -->
                <button type="button" class="btn btn-outline-primary ms-1" data-bs-toggle="modal" data-bs-target="#editarModal">
                  Editar
                </button>
                <a href="../config/cerrarSesion.php">
                  <button type="button" class="btn btn-outline-danger ms-1">Cerrar Sesión</button>
                </a>
              </div>
            </div>
          </div>
          <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">
              <ul class="list-group list-group-flush rounded-3">
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="bi bi-instagram"></i>
                  <p class="mb-0"><?php if (isset($_SESSION['usuario']['instagram'])) echo $_SESSION['usuario']['instagram']; ?></p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <i class="bi bi-facebook"></i>
                  <p class="mb-0"><?php if (isset($_SESSION['usuario']['facebook'])) echo $_SESSION['usuario']['facebook']; ?></p>
                </li>
                <a href="./AgregarRedes.php">
                  <button type="button" class="btn btn-outline-primary ms-1" style="align-items: center;">Agregar</button>
                </a>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Nombre Completo</p>
                </div>
                <div class="col-sm-9">
                  <?php $nombre = $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellido1'] . ' ' . $_SESSION['usuario']['apellido2']; ?>
                  <p class="text-muted mb-0"><?php echo $nombre; ?></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Correo Electrónico</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?php if (isset($_SESSION['usuario']['email'])) echo $_SESSION['usuario']['email']; ?></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Número de Teléfono</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?php if (isset($_SESSION['usuario']['telefono'])) echo $_SESSION['usuario']['telefono']; ?></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Edad</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?php if (isset($_SESSION['usuario']['edad'])) echo $_SESSION['usuario']['edad']; ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <?php
              if (isset($_SESSION['usuario']['nombreRol']) && $_SESSION['usuario']['nombreRol'] === 'POSTULANTE') {
                echo '<div class="card mb-4 mb-md-0">
                        <div class="card-body">
                          <p class="mb-4"><span class="text-primary font-italic me-1">Trabajos</span> Trabajos Terminados</p>
                          <p class="mb-1" style="font-size: .77rem;">****</p>
                          <div class="progress rounded" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <p class="mt-4 mb-1" style="font-size: .77rem;">***</p>
                          <div class="progress rounded" style="height: 5px;">
                            <div class="progress-bar"></div>
                          </div>
                          <p class="mt-4 mb-1" style="font-size: .77rem;">****</p>
                          <div class="progress rounded" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <p class="mt-4 mb-1" style="font-size: .77rem;">****</p>
                          <div class="progress rounded" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <p class="mt-4 mb-1" style="font-size: .77rem;">****</p>
                          <div class="progress rounded mb-2" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>';
              }
              ?>
            </div>
            <div class="col-md-6">
              <?php
              if (isset($_SESSION['usuario']['nombreRol']) && $_SESSION['usuario']['nombreRol'] === 'POSTULANTE') {
                echo '<div class="card mb-4 mb-md-0">
                        <div class="card-body">
                          <p class="mb-4"><span class="text-primary font-italic me-1">Trabajos</span> Trabajos en Oferta</p>
                          <p class="mb-1" style="font-size: .77rem;">***</p>
                          <p class="mt-4 mb-1" style="font-size: .77rem;">***</p>
                          <p class="mt-4 mb-1" style="font-size: .77rem;">***</p>
                          <p class="mt-4 mb-1" style="font-size: .77rem;">****</p>
                          <p class="mt-4 mb-1" style="font-size: .77rem;">****</p>
                        </div>
                      </div>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal de Edición -->
  <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editarModalLabel">Editar Perfil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editaruser" method="post" action="../controllers/UserController.php?op=editarPerfil">  

            <div class="form-group mb-4">
              <label for="nombre">Nombre:</label>
              <input name="nombre" type="text" class="form-control" id="nombre" value= '<?php if (isset($_SESSION['usuario']['nombre'])) echo $_SESSION['usuario']['nombre']; ?>' placeholder="Ingrese su nombre" required />
              <p class="text-danger"></p>
            </div>

            <div class="form-group mb-4">
              <label for="cedula">Cedula:</label>
              <input name="cedula" type="text" class="form-control" id="cedula" value= '<?php if (isset($_SESSION['usuario']['cedula'])) echo $_SESSION['usuario']['cedula']; ?>' placeholder="Ingrese su cedula" required />
              <p class="text-danger"></p>
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
              <input name="direccion" type="text" class="form-control" id="direccion" value= '<?php if (isset($_SESSION['usuario']['direccion'])) echo $_SESSION['usuario']['direccion']; ?>' placeholder="Ingrese su dirección" required />
              <p class="text-danger"></p>
            </div>

            <div class="form-group mb-4">
              <label for="telefono">Teléfono:</label>
              <input name="telefono" type="number" class="form-control" id="telefono" value='<?php if (isset($_SESSION['usuario']['telefono'])) echo $_SESSION['usuario']['telefono']; ?>' placeholder="Ingrese el número de teléfono" required />
              <p class="text-danger"></p>
            </div>

            <div class="form-group mb-4">
              <label for="email">Email:</label>
              <input name="email" type="email" class="form-control" id="email" value='<?php if (isset($_SESSION['usuario']['email'])) echo $_SESSION['usuario']['email']; ?>' placeholder="Ingrese su email" required />
              <p class="text-danger"></p>
            </div>

            <div class="form-group mb-4">
              <label for="instagram">Instagram:</label>
              <input name="instagram" type="text" class="form-control" id="instagram" value='<?php if (isset($_SESSION['usuario']['instagram'])) echo $_SESSION['usuario']['instagram']; ?>' placeholder="Ingrese su instagram" />
              <p class="text-danger"></p>
            </div>

            <div class="form-group mb-4">
              <label for="facebook">Facebook:</label>
              <input name="facebook" type="text" class="form-control" id="facebook" value='<?php if (isset($_SESSION['usuario']['facebook'])) echo $_SESSION['usuario']['facebook']; ?>' placeholder="Ingrese su Facebook" />
              <p class="text-danger"></p>
            </div>

            <div class="form-group mb-4">
              <label for="edt-imagen">Imagen:</label>
              <input name="imagen" type="file" class="form-control" id="edt-imagen" />
              <p class="text-danger"></p>
            </div>

            <input type="hidden" name="id" value="<?php echo $_SESSION['usuario']['idUsuario']; ?>">
            <input type="hidden" name="oldImagenUrl" value="<?php echo $_SESSION['usuario']['imagen_url']; ?>">

            <button type="submit" class="btn btn-primary">Guardar</button>
          </form>
          
        </div>
      </div>
    </div>
  </div>
  <?php include("./assets/fragmentos/footer.php"); ?>
  <?php include("./assets/fragmentos/scripts.php"); ?>
  <script type="module" src="./assets/js/perfil.js"></script>
  <script type="module" src="./assets/js/index.js"></script>
</body>

</html>