<?php
// Inicia la sesión si es necesario
session_start();
?>
<!DOCTYPE html>
<html lang="es">


<?php
include("./assets/fragmentos/head.php");

include("./assets/fragmentos/sinSesion401.php");
?>


<body>
<style>
            /* Estilo general para las tarjetas */
    .card {
        transition: transform 0.2s; 
        height: 100%; 
        display: flex; 
        flex-direction: column; 
    }

    /* Efecto de movimiento */
    .card:hover {
        transform: scale(1.05); 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); 
    }

    /* Asegura que las imágenes de las tarjetas sean del mismo tamaño */
    .card-img-top {
        height: 200px; 
        object-fit: cover; 
    }

    /* Asegura que el cuerpo de la tarjeta ocupe el espacio restante */
    .card-body {
        flex-grow: 1; 
    }


     </style>
    <?php include("../config/session.php"); ?> <!--PARA COLOCAR EL HEADER DEPENDIENDO DEL ROL-->

    <!--Estructura HTML para el filtro-->

    <div class="container mt-4">
        <label for="categoryFilter">Filtrar por categoría:</label>
        <select id="categoryFilter" class="form-select" onchange="filterProducts()">
            <option value="all">Todas</option>
            <?php
            include('../models/publicacionesModel.php');
            $publicaciones = new Publicacion();
            $arr = $publicaciones->listarCategorias();
            foreach ($arr as $categoria) {
                echo '<option value="' . $categoria['ID_CATEGORIA_PK'] . '">' . $categoria['NOMBRE_CATEGORIA'] . '</option>';
            }
            ?>
        </select>

        <!-- Botón para postular un nuevo trabajo -->
        <?php
        if ($_SESSION['usuario']['nombreRol'] === 'POSTULANTE') {
            echo '<button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#postJobModal">Postular un nuevo trabajo</button>';
        }
        ?>

    </div>
    <section>
        <div class="container px-4 px-lg-5 mt-5">
            <ul class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center" id="listaPublicaciones">
                <?php

                function listarPublicaciones($publicaciones){
                    //$publicaciones = new Publicacion();
                    $arr = $publicaciones->listarPublicaciones();
                    //var_dump($arr);
                    foreach ($arr as $publicacion) {
                        $card = '<li class="nav-item">
    <div class="col mb-5" data-category="' . $publicacion['ID_CATEGORIA_FK'] . '">
        <div class="card h-100">
            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
            <div class="card-body p-4">
                <div class="text-center">
                    <h5 class="fw-bolder">' . $publicacion['TITULO_PUBLICACION'] . '</h5>
                    ' . $publicacion['PRECIO_APROX'] . ' ₡
                </div>
            </div>
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center">
                    <a class="btn btn-outline-primary mt-auto" href="#" onclick="editPublication(' . $publicacion['ID_PUBLICACION_PK'] . ')" data-bs-toggle="modal" data-bs-target="#editJobModal">Editar</a>
                    <button class="btn btn-danger mt-auto" onclick="deletePublication(' . $publicacion['ID_PUBLICACION_PK'] . ')">Eliminar</button>
                    <a class="btn btn-outline-primary mt-auto" href="#" data-bs-toggle="modal" data-bs-target="#applicationModal">Ver empleo</a>
                </div>
            </div>
        </div>
    </div>
</li>';

                        switch ($_SESSION['usuario']['nombreRol']) {

                            case 'ADMIN':
                                if ($publicacion['ID_ESTADO_FK'] != 2) { //pintar solo publicaciones con estado activo (el 2 es el inactivo)
                                    echo $card;
                                }
                                break;

                            case 'RECLUTADOR':
                                if ($publicacion['ID_ESTADO_FK'] != 2) { //mostrar todas las publicaciones activas
                                    echo $card;
                                }
                                break;

                            case 'POSTULANTE':
                                if ($publicacion['ID_USUARIO_FK'] == $_SESSION['usuario']['idUsuario']) { //mostrar unicamente las publicaciones del usuario logueado
                                    echo $card;
                                }
                                break;
                        }
                    }
                }
                //llamar al metodo de listar publicaciones
                listarPublicaciones($publicaciones);

                ?>
            </ul>

    </section>
<!-- Modal para editar publicación -->
<div class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="editJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJobModalLabel">Editar Publicación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditJob">
                    <input type="hidden" id="editJobId" name="editJobId">
                    <div class="mb-3">
                        <label for="editTitulo" class="form-label">Título del Trabajo</label>
                        <input type="text" class="form-control" id="editTitulo" name="editTitulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescripcion" class="form-label">Descripción del Trabajo</label>
                        <textarea class="form-control" id="editDescripcion" rows="3" name="editDescripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editUbicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="editUbicacion" name="editUbicacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPrecio" class="form-label">Precio aproximado</label>
                        <input type="number" class="form-control" id="editPrecio" name="editPrecio" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="updateJob">Actualizar Publicación</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal para postular un nuevo trabajo -->
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center" id="jobContainer">
        <div class="modal fade" id="postJobModal" tabindex="-1" aria-labelledby="postJobModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postJobModalLabel">Postular un Nuevo Trabajo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formPostularTrabajo" >
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título del Trabajo</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción del Trabajo</label>
                                <textarea class="form-control" id="descripcion" rows="3"  name="descripcion" required></textarea>
                            </div>

                            <div class="mb-3">
                                <select id="categoriaPublicacionSelect" class="form-select" name="categoria" required>
                                    <?php
                                    $cat = $publicaciones->listarCategorias();
                                    foreach ($cat as $categoria) {
                                        echo '<option value="' . $categoria['ID_CATEGORIA_PK'] . '">' . $categoria['NOMBRE_CATEGORIA'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" name="ubicacion" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio aproximado</label>
                                <input type="number" class="form-control" id="precio" name="precio" name="precio" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="subirTrabajo">Subir Empleo</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para postulación -->
        <div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="applicationModalLabel">Formulario de Postulación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="applicationForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="message" rows="3" required></textarea>
                            </div>
                            <div id="responseMessage" class="alert alert-success" style="display: none;"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="submitApplication">Enviar Postulación</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include("./assets/fragmentos/footer.php"); ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./assets/js/publicaciones.js"></script>
<?php include("./assets/fragmentos/scripts.php"); ?>

</html>