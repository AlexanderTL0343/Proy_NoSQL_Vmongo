// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.5.0/firebase-app.js";
import { getStorage, ref, uploadBytes, getDownloadURL, deleteObject } from "https://www.gstatic.com/firebasejs/11.5.0/firebase-storage.js";
import { firebaseConfig } from "../../../config/global.js"; //por seguridad se almacena por aparte

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const storage = getStorage(app);

async function uploadImageAndGetUrl(file, path = 'usuarios/') {
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

async function updateImageByUrl(publicUrl, newFile, path = 'usuarios/') {
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

function limpiarFormularioAgregar() {
    document.getElementById("instagram").value = "";
    document.getElementById("facebook").value = "";
}

//INSETAR REDES
$(document).ready(function () {
    $("#guardarRedes").on("submit", function (e) {
      e.preventDefault();
      var formData = new FormData($("#guardarRedes")[0]);
      $.ajax({
        url: "../controllers/UserController.php?op=insertarRedes",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          response = JSON.parse(response);
          switch (response[0].status) {
            case true:
                limpiarFormularioAgregar();
              Swal.fire({
                  icon: "success",
                  title: "Redes registradas exitosamente",
                  showConfirmButton: false,
                  timer: 1800,
                }).then(() => {
                  // Redirigir después de que el cuadro desaparezca
                  window.location.href = "Perfil.php";  
                })
              break;
  
            case false:
              alert("Error al registrar las Redes");
              break;
          }
        },
        error: function (err) {
          console.error("Error en la solicitud AJAX:", err);
          alert("Error inesperado al registrar las Redes");
        },
      });
    });
  });

$('#editaruser').on('submit', function (event) {
event.preventDefault(); // Evita que el formulario se envíe de forma tradicional

// Mostrar un cuadro de confirmación con SweetAlert
Swal.fire({
    title: '¿Estás seguro?',
    text: '¿Desea modificar los datos?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, modificar',
    cancelButtonText: 'Cancelar',
}).then( async (result) => {
    if (result.isConfirmed) {
        // Si el usuario confirma, enviar los datos por AJAX
        var formData = new FormData($('#editaruser')[0]);

        var file = document.getElementById("edt-imagen").files[0];
        let oldImagenUrl = formData.get("oldImagenUrl");

        console.log(oldImagenUrl);

        if (file) { //SI SE SELECCIONA UNA IMAGEN EN EL EDITAR, SE ACTUALIZA
            let newImagenUrl = await updateImageByUrl(oldImagenUrl, file);
            formData.append("imagen", newImagenUrl);
            console.log(newImagenUrl);
        } else{
            formData.append("imagen", oldImagenUrl);
        }
        //pendiente revisar

        $.ajax({
            url: '../controllers/UserController.php?op=editar',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                // Manejar la respuesta del servidor
                switch (String(datos)) {
                    case "0":
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al modificar los datos',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location.reload(); // Recargar la página después de cerrar la alerta
                        });
                        break;
                    case "1":
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Usuario actualizado exitosamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            actualizarSesion(formData.get("id"));
                            location.reload();
                        });
                        break;
                    case "2":
                        Swal.fire({
                            title: 'Error',
                            text: 'ID incorrecta',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        break;
                }
            },
            error: function (xhr, status, error) {
                // Manejar errores de la solicitud AJAX
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al enviar la solicitud',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }
});
});

function actualizarSesion(id_usuario){
    console.log("ID enviado a AJAX:", id_usuario);
    $.ajax({
        url: '../controllers/UserController.php?op=actualizarVariablesSesion',
        type: 'POST',
        data: {idUsuario: id_usuario},
        success: function (datos) {
            // Manejar la respuesta del servidor

            console.log("Respuesta bruta del servidor:", datos);

            var response = JSON.parse(datos); // Intentar parsear JSON
            console.log("Respuesta procesada:", response);


            switch (datos.status) {
                case true:
                    console.log("Variables de sesión actualizadas correctamente.");
                    break;
                case false:
                    Swal.fire({
                        icon: "error",
                        title: "Error al actualizar las variables de sesión",
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
                title: "Error al actualizar las variables de sesión",
                text: "Revisa los errores y vuelve a intentarlo.",
                showConfirmButton: false,
                timer: 1800,
            });
        },
    });
}
