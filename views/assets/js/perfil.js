function limpiarFormularioAgregar() {
    document.getElementById("instagram").value = "";
    document.getElementById("facebook").value = "";
}

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
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, enviar los datos por AJAX
            var formData = new FormData($('#editaruser')[0]);

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
                                location.reload(); // Recargar la página después de cerrar la alerta
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