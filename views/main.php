<?php
session_start();
include("./assets/fragmentos/head.php");
include("./assets/fragmentos/sinSesion401.php");
include("../config/session.php"); // Dependiendo del rol
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <style>
        .card {
            transition: transform 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            flex-grow: 1;
        }
    </style>
</head>
<body>

<div hidden id="nombreRol" data-value="<?php echo $_SESSION['usuario']['nombreRol']; ?>"></div>

<div class="container mt-4">
    <label for="categoryFilter">Filtrar por categoría:</label>
    <select id="categoryFilter" class="form-select">
        <option value="all">Todas</option>
    </select>

    <?php if ($_SESSION['usuario']['nombreRol'] === 'RECLUTADOR' || $_SESSION['usuario']['nombreRol'] === 'ADMIN') : ?>
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addPublicationModal">Postular un nuevo trabajo</button>
    <?php endif; ?>
</div>

<section>
    <div class="container px-4 px-lg-5 mt-5">
        <ul class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center" id="listaPublicaciones">
            <!-- Aquí se cargarán dinámicamente las publicaciones -->
        </ul>
    </div>
</section>

<!-- Modal para agregar una publicación -->
<div class="modal fade" id="addPublicationModal" tabindex="-1" aria-labelledby="addPublicationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPublicationModalLabel">Agregar Nueva Publicación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formAddPublication">
          <div class="mb-3">
            <label for="titulo_publicacion" class="form-label">Título de la Publicación</label>
            <input type="text" class="form-control" id="titulo_publicacion" name="titulo_publicacion" required>
          </div>

          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" rows="3" name="descripcion" required></textarea>
          </div>

          <div class="mb-3">
            <label for="precio_aprox" class="form-label">Precio Aproximado</label>
            <input type="number" class="form-control" id="precio_aprox" name="precio_aprox" required>

          </div> Ubicación
          <div class="row">

            <div class="mb-3 col">
                <input type="text" class="form-control"  placeholder="Provincia" name="provincia" required>
            </div>

            <div class="mb-3 col">
                <input type="text" class="form-control" placeholder="Ciudad" name="ciudad" required>
            </div>

            <div class="mb-3 col">
                <input type="text" class="form-control"  placeholder="Dirección" name="direccion" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select class="form-control" id="form-p-categoria" name="categoria" required>
              <!-- SE AGREGAN EN EL JS DE MANERA DINAMICA-->
            </select>
          </div>

          <div class="mb-3">
            <label for="imagen_url" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen_url" name="imagenUrl" placeholder="URL de la imagen (opcional)">
          </div>

          <input type="hidden" name="id_estado_fk" value="1">

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="submitPublication">Subir</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para editar una publicación -->
<div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editJobModalLabel">Editar Publicación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditJob">
          <div class="mb-3">
            <label for="edit_titulo_publicacion" class="form-label">Título de la Publicación</label>
            <input type="text" class="form-control" id="edit_titulo_publicacion" name="titulo_publicacion" required>
          </div>

          <div class="mb-3">
            <label for="edit_descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="edit_descripcion" rows="3" name="descripcion" required></textarea>
          </div>

          <div class="mb-3">
            <label for="edit_precio_aprox" class="form-label">Precio Aproximado</label>
            <input type="number" class="form-control" id="edit_precio_aprox" name="precio_aprox" required>
          </div>

          <div class="row">
            <div class="mb-3 col">
                <input type="text" class="form-control" id="edit_provincia" name="provincia" placeholder="Provincia" required>
            </div>
            <div class="mb-3 col">
                <input type="text" class="form-control" id="edit_ciudad" name="ciudad" placeholder="Ciudad" required>
            </div>
            <div class="mb-3 col">
                <input type="text" class="form-control" id="edit_direccion" name="direccion" placeholder="Dirección" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="edit_categoria" class="form-label">Categoría</label>
            <select class="form-control" id="edit_categoria" name="categoria" required>
              <!-- SE AGREGAN EN EL JS DE MANERA DINAMICA-->
            </select>
          </div>

          <div class="mb-3">
            <label for="edit_imagen_url" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="edit_imagen_url" name="imagenUrl" placeholder="URL de la imagen (opcional)">
          </div>

          <input type="hidden" name="url_imagen" id="edit_url_imagen">
          <input type="hidden" name="id_usuario_fk" id="edit_id_usuario_fk">
          <input type="hidden" name="id_publicacion" id="edit_id_publicacion">
          <input type="hidden" name="id_estado_fk" value="1"><!--ESTO DEBE CAMBIAR-->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="actualizarPublicacion">Actualizar</button>
      </div>
    </div>
  </div>
</div>


<?php include("./assets/fragmentos/footer.php"); ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="module" src="assets/js/publicaciones.js"></script>
<?php include("./assets/fragmentos/scripts.php"); ?>

</html>
