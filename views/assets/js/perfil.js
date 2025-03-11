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
    event.preventDefault();
    bootbox.confirm('¿Desea modificar los datos?', function (result) {
      if (result) {
        var formData = new FormData($('#editaruser')[0]);
        $.ajax({
  
          url: '../controllers/UserController.php?op=editar',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function (datos) {
            alert(datos)
            switch (String(datos)) {
              case "0":
                alert('Error al modificar los datos');
                location.reload();
                break;
              case "1":
                alert('Usuario actualizado exitosamente');
                location.reload();
                break;
              case "2":
                alert('ID incorrecta');
                break;
            }
          },
        });
      }
    });
  });