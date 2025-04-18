// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.5.0/firebase-app.js";
import { getStorage, ref, uploadBytes, getDownloadURL, deleteObject  } from "https://www.gstatic.com/firebasejs/11.5.0/firebase-storage.js";
import { firebaseConfig } from "../../../config/global.js"; //por seguridad se almacena por aparte

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const storage = getStorage(app);

    async function uploadImageAndGetUrl(file, path = 'images/') {
        try {
            // Crea una referencia al archivo en Firebase Storage
            const storageRef = ref(storage, path + file.name);

            // Sube el archivo a Firebase Storage
            await uploadBytes(storageRef, file);

            // Obtiene la URL pública del archivo subido
            const downloadUrl = await getDownloadURL(storageRef);

            // Devuelve la URL pública
            return downloadUrl;
        } catch (error) {
            console.error("Error al subir la imagen:", error);
            throw error; // Lanza el error para manejarlo en el código que llama a esta función
        }
    }
    
    async function deleteImageByUrl(publicUrl) {
        try {
            // Extraer el path relativo del archivo
            const path = publicUrl.split("/o/")[1].split("?")[0]; // Obtener desde "images/...png"
            const decodedPath = decodeURIComponent(path); // Decodificar caracteres como %2F
    
            // Crear referencia al archivo
            const fileRef = ref(storage, decodedPath);
    
            // Eliminar el archivo
            await deleteObject(fileRef);
            console.log("Archivo eliminado exitosamente:", decodedPath);
        } catch (error) {
            console.error("Error al eliminar la imagen:", error.message);
        }
    }

    async function updateImageByUrl(publicUrl, newFile, path = 'images/') {
        try {
          // Extraer el path relativo del archivo de la URL pública
          const pathToFile = publicUrl.split("/o/")[1].split("?")[0]; // Obtener el path desde "images/...png"
          const decodedPath = decodeURIComponent(pathToFile); // Decodificar caracteres como %2F
      
          // Crear referencia al archivo en Firebase Storage
          const fileRef = ref(storage, decodedPath);
      
          // Eliminar el archivo anterior
          await deleteObject(fileRef);
          console.log("Archivo anterior eliminado exitosamente:", decodedPath);
      
          // Crear una referencia para el nuevo archivo
          const newStorageRef = ref(storage, path + newFile.name);
      
          // Subir el nuevo archivo
          await uploadBytes(newStorageRef, newFile);
      
          // Obtener la URL pública del nuevo archivo
          const newDownloadUrl = await getDownloadURL(newStorageRef);
      
          // Devolver la nueva URL pública
          return newDownloadUrl;
        } catch (error) {
          console.error("Error al actualizar la imagen:", error.message);
          throw error; // Lanza el error para manejarlo en el código que llama a esta función
        }
      }

//---------------------------------------------------------------------------------------


$(document).ready(function () {
    cargarCategorias();
    cargarPublicaciones();
    $("#categoryFilter").on("change", filterProducts);
});

// Cargar categorías en el filtro
function cargarCategorias() {
    $.ajax({
        url: "../controllers/publicacionController.php?op=listarCategorias",
        type: "GET",
        success: function (response) {
            response = JSON.parse(response);

            if (response.status) {
                let opciones = '<option value="all">Todas</option>';
                response.datos.forEach((categoria) => {
                    opciones += `<option value="${categoria._id}">${categoria.nombreCategoria}</option>`;
                });
                $("#categoryFilter").html(opciones);
                $("#form-p-categoria").html(opciones);
                $("#edit_categoria").html(opciones);
            }
        },
        error: function () {
            console.error("Error al obtener las categorias.");
        },
    });
}

// Cargar publicaciones dinámicamente
function cargarPublicaciones() {
    $.ajax({
        url: "../controllers/publicacionController.php?op=listarPublicaciones",
        type: "GET",
        success: function (response) {
            response = JSON.parse(response);
            if (response.status) {
                let html = response.datos.map(generarCard).join("");
                $("#listaPublicaciones").html(html);
            } else {
                $("#listaPublicaciones").html(
                    "<p>No hay publicaciones disponibles.</p>"
                );
            }
        },
        error: function () {
            console.error("Error al obtener publicaciones.");
        },
    });
}

// Generar una tarjeta de publicación
function generarCard(publicacion) {
    let nombreRol = document.getElementById("nombreRol").getAttribute("data-value");
    let imagenUrl;

    if (publicacion.imagen_url != "" && publicacion.imagen_url != " " ) {
        imagenUrl = publicacion.imagen_url;
    } else {
        imagenUrl = "https://dummyimage.com/450x300/dee2e6/6c757d.jpg";
    }

    return `
      <li class="nav-item" data-category="${publicacion.id_categoria_fk}">
          <div class="col mb-5"">
              <div class="card h-100">
                  <img class="card-img-top" src="${imagenUrl}" alt="..." />
                  <div class="card-body p-4">
                      <div class="text-center">
                          <h5 class="fw-bolder">${publicacion.titulo_publicacion}</h5>
                          <p class="text-muted">${publicacion.precio_aprox} ₡</p>
                      </div>
                </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="d-flex justify-content-between gap-2">
                            <!-- Botón de Ver Empleo -->
                            <a class="btn btn-outline-primary flex-fill" href="#" data-bs-toggle="modal" data-bs-target="#applicationModal">Ver</a>
                                
                            ${nombreRol === "RECLUTADOR" || nombreRol === "ADMIN" ? `
                                <!-- Botón de Editar -->
                                <a class="btn-modal-editar btn btn-outline-primary flex-fill" href="#" data-id="${publicacion._id}" data-bs-toggle="modal" data-bs-target="#editJobModal">Editar</a>
                            ` : ""}
                            
                            ${nombreRol === "RECLUTADOR" || nombreRol === "ADMIN" ? `
                                <!-- Botón de Eliminar -->
                                <button class="btn btn-outline-danger flex-fill btn-eliminar" data-id="${publicacion._id}">Eliminar</button>

                            ` : ""}
                        </div>
                    </div>
              </div>
          </div>
      </li>
  `;
}

// Filtrar publicaciones por categoría
function filterProducts() {
    let selectedCategory = $("#categoryFilter").val();
    $("#listaPublicaciones li").each(function () {
        let category = $(this).data("category"); // Ahora sí debería funcionar
        $(this).toggle(selectedCategory === "all" || String(category) === String(selectedCategory));
    });
}

// Subir una nueva publicación
$(document).ready(function () {
    $("#submitPublication").on("click", async function (e) {
        e.preventDefault();

        var formData = new FormData($("#formAddPublication")[0]);

        var file = document.getElementById("imagen_url").files[0];

        if (file) {
            try {
                const ImgUrl = await uploadImageAndGetUrl(file);
                formData.append("imagenUrl", ImgUrl);
            } catch (error) {
                console.error("Error al subir la imagen:", error);
                return;
            }
        }else {
            formData.append("imagenUrl", ""); // O usa null según lo que necesite tu backend
        }

        $.ajax({
            url: "../controllers/publicacionController.php?op=insertarPublicacion",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = JSON.parse(response);
                switch (response.status) {
                    case true:
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                            text: "¡Gracias por compartir tu trabajo!",
                            showConfirmButton: false,
                            timer: 1800,
                        }).then(() => {
                            // Redirigir después de que el cuadro desaparezca
                            window.location.href = "main.php";
                        });
                        break;

                    case false:
                        Swal.fire({
                            icon: "error",
                            title: response.message,
                            text: "Revisa los errores y vuelve a intentarlo.",
                            showConfirmButton: false,
                            timer: 1800,
                        });
                        break;
                }
            },
            error: function (err) {
                console.error("Error en la solicitud AJAX:", err);
                Swal.fire({
                    icon: "error",
                    title: "Error al crear la publicación",
                    text: "Revisa los errores y vuelve a intentarlo.",
                    showConfirmButton: false,
                    timer: 1800,
                });
            },
        });
    });
});

function limpiarFormularioEdicion() {
    $("#edit_titulo_publicacion").val(" ");
    $("#edit_categoria").val(" ");
    $("#edit_descripcion").val(" ");
    $("#edit_precio_aprox").val(" ");
    $("#edit_provincia").val(" ");
    $("#edit_ciudad").val(" ");
    $("#edit_direccion").val(" ");
    $("#edit_imagen_url").val("");
    $("#edit_id_publicacion").val(" ");
}

// Función para cargar los datos de la publicación en el modal de edición
$(document).on("click", ".btn-modal-editar", function() {
    let id = $(this).data("id");
    cargarDatosModalEditar(id);
});


// Actualizar publicación
// Función para editar una publicación
function cargarDatosModalEditar(id) {
    console.log("id al iniciar editar publicacion "+id);
    limpiarFormularioEdicion();  // Limpiar el formulario antes de cargar la publicación
    $.ajax({
        url: "../controllers/publicacionController.php?op=obtenerPublicacion",
        type: "GET",
        data: { id: id },
        success: function (response) {
            response = JSON.parse(response);
            if (response.status) {
                const pub = response.datos;
                //cargarCategorias(); ya se llama cunado el doc esta listo

                // Poblamos los campos del modal con los datos de la publicación
                $("#edit_titulo_publicacion").val(pub.titulo_publicacion);
                $("#edit_categoria").val(pub.id_categoria_fk);
                $("#edit_descripcion").val(pub.descripcion);
                $("#edit_precio_aprox").val(pub.precio_aprox);
                $("#edit_provincia").val(pub.ubicacion.provincia);
                $("#edit_ciudad").val(pub.ubicacion.ciudad);
                $("#edit_direccion").val(pub.ubicacion.direccion_detallada);
                $("#edit_url_imagen").val(pub.imagen_url);
                $("#edit_id_publicacion").val(pub._id);
                $("#edit_id_usuario_fk").val(pub.id_usuario_fk);
                console.log("id del usuario punlicacion modal "+pub.id_usuario_fk);   
                //console.log("id de la publicación "+pub._id);
                
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error al obtener los datos",
                    text: "No se pudo cargar la publicación para editarla.",
                });
            }
        },
        error: function () {
            console.error("Error al obtener la publicación.");
        },
    });
}


// Función para actualizar la publicación
$("#actualizarPublicacion").click(function (e) {
    e.preventDefault();

    swal.fire({
        title: '¿Estás seguro?',
        text: '¿Desea actualizar esta publicación?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar',
    }).then( async (result) => {
        if (result.isConfirmed) {

            var formData = new FormData($("#formEditJob")[0]);
            var file = document.getElementById("edit_imagen_url").files[0];
            var urlImagen = document.getElementById("edit_url_imagen").value;
            
            console.log("url de la URLimagen "+ urlImagen);   
            console.log("URL de imagen anterior:", urlImagen);

            if(file){ //si el usuario selecciona una nueva imagen
                if (urlImagen === "" || urlImagen === " ") { // Si no hay imagen previa, subir una nueva
                    let newImagenUrl = await uploadImageAndGetUrl(file);
                    formData.append("imagenUrl", newImagenUrl);
                    console.log("Subida nueva imagen: " + newImagenUrl);
                } else { // Si ya hay una imagen previa, actualizarla
                    let newImagenUrl = await updateImageByUrl(urlImagen, file);
                    formData.append("imagenUrl", newImagenUrl);
                    console.log("Imagen actualizada: " + newImagenUrl);
                }
            }else{
                console.log("url de la img en el else  "+ urlImagen);
                formData.append("imagenUrl", urlImagen);//revisar
            }

            //console.log("id de la publicación "+ formData.get("id_publicacion"));
            console.log("url de la img "+ formData.get("imagenUrl"));

            $.ajax({
                url: "../controllers/publicacionController.php?op=actualizarPublicacion",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1800,
                        }).then(() => {
                            // Redirigir o recargar para mostrar la publicación actualizada
                            window.location.href = "main.php";
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: response.message,
                            text: "Revisa los errores y vuelve a intentarlo.",
                            showConfirmButton: false,
                            timer: 1800,
                        });
                    }
                },
                error: function (err) {
                    console.error("Error en la solicitud AJAX:", err);
                    Swal.fire({
                        icon: "error",
                        title: "Error al actualizar la publicación",
                        text: "Revisa los errores y vuelve a intentarlo.",
                        showConfirmButton: false,
                        timer: 1800,
                    });
                },
            });
        }else{

            //pendiente si no se confirma el editar
        }
    }); 
   
});







// Eliminar publicación
$(document).on("click", ".btn-eliminar", function() {
    let id = $(this).data("id");
    eliminarPublicacion(id);
});

function eliminarPublicacion(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Desea eliminar esta publicación?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controllers/publicacionController.php?op=eliminarPublicacion",
                type: "POST",
                data: {id: id,},
                success: function (response) {
                    response = JSON.parse(response);
                    console.log(response.img_url);

                    switch (response.status) {
                        case true:
                            deleteImageByUrl(response.img_url);//borrar imagen del firebase
                            Swal.fire({
                                icon: "success",
                                title: "Publicación eliminada exitosamente",
                                showConfirmButton: false,
                                timer: 1800,
                            }).then(() => {
                                cargarPublicaciones();
                            });
                            break;

                        case false:
                            Swal.fire({
                                icon: "error",
                                title: response.message,
                                text: "Revisa los errores y vuelve a intentarlo.",
                                showConfirmButton: false,
                                timer: 1800,
                            });
                            break;
                    }
                },
                error: function (err) {
                    console.error("Error en la solicitud AJAX:", err);
                    Swal.fire({
                        icon: "error",
                        title: "Error al eliminar la publicación",
                        text: "Revisa los errores y vuelve a intentarlo.",
                        showConfirmButton: false,
                        timer: 1800,
                    });
                },
            });
        }
    });
}

// Enviar postulación
function enviarPostulacion() {
    let formData = $("#applicationForm").serialize();
    $.post(
        "../controllers/publicacionController.php",
        formData + "&action=enviarPostulacion"
    )
        .done(() => {
            alert("Postulación enviada.");
            $("#applicationModal").modal("hide");
        })
        .fail(() => alert("Error al enviar la postulación."));
}


