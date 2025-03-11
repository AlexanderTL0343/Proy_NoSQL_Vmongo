function limpiarFormulario() {
  document.getElementById("cedula").value = "";
  document.getElementById("nombre").value = "";
  document.getElementById("apellido1").value = "";
  document.getElementById("email").value = "";
  document.getElementById("contrasena").value = "";
  document.getElementById("edad").value = "";
  document.getElementById("direccion").value = "";
  document.getElementById("telefono").value = "";
}

function listarProfesiones(){
  $.ajax({
    url: "../controllers/UserController.php?op=obtenerProfesiones",
    type: "GET",
    success: function (datos) {
      datos = JSON.parse(datos);
      switch (datos[0].status) {
        case true:
          console.log(datos[0].datos);

          const selectProfesion = document.getElementById("profesion");
          selectProfesion.innerHTML = ""; // Limpiar las opciones existentes
          
          datos[0].datos.forEach(profesion => {
            const opt = document.createElement("option");//crear el option
            opt.value = profesion.ID_PROFESION_PK; //asignar el valor
            opt.text = profesion.NOMBRE_PROFESION; //asignar el texto que se muestra
            selectProfesion.appendChild(opt); //insertar el option en el select
          });
          
          break;

        case false:
          alert("Error al obtener las profesiones");
          break;
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud AJAX:", xhr.status, xhr.statusText);
      alert("Error inesperado al obtener las profesiones");
    },
  });
}
/*document.getElementById("profesion").addEventListener("change", function () {
  console.log(document.getElementById("profesion").value);
});*/
listarProfesiones();


//FUNCION PARA HABILITAR EL BOTON DE REGISTRAR POR EL CHECKBOX
document.addEventListener("DOMContentLoaded", function () {
  // Referencias a los elementos
  const checkbox = document.getElementById("checkTerminos");
  const botonRegistro = document.getElementById("botonRegistro");

  // Verifica si los elementos existen en el DOM
  if (checkbox && botonRegistro) {
    // Agregar el evento solo si los elementos existen
    checkbox.addEventListener("change", function () {
      botonRegistro.disabled = !this.checked;
    });
  }
});

//FUNCION PARA REGISTRAR USUARIO
$(document).ready(function () {
  $("#registroUsuario").on("submit", function (e) {
    e.preventDefault();
    var formData = new FormData($("#registroUsuario")[0]);
    $.ajax({
      url: "../controllers/UserController.php?op=insertarUsuario",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        response = JSON.parse(response);
        switch (response[0].status) {
          case true:
            limpiarFormulario();
            Swal.fire({
                icon: "success",
                title: "Usuario registrado exitosamente",
                showConfirmButton: false,
                timer: 1800,
              }).then(() => {
                // Redirigir después de que el cuadro desaparezca
                window.location.href = "index.php";  
              })
            break;

          case false:
            alert("Error al registrar el usuario");
            break;
        }
      },
      error: function (err) {
        console.error("Error en la solicitud AJAX:", err);
        alert("Error inesperado al registrar el usuario");
      },
    });
  });
});
//-----------------------------------------------------
function limpiarFormLogin() {
  document.getElementById("email").value = "";
  document.getElementById("contrasena").value = "";
}

//Funcion para iniciar sesion
$("#login").on("submit", function (e) {
  e.preventDefault();
  var formData = new FormData($("#login")[0]);
  $.ajax({
    url: "../controllers/UserController.php?op=iniciarSesion",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    
    success: function (datos) {
      console.log(datos);
      datos = JSON.parse(datos);
      switch (datos[0].status) {
        case true:
          limpiarFormLogin();
          console.log(datos[0].nombreRol);
          Swal.fire({
            icon: "success",
            title: "Sesión iniciada",
            text: "¡Bienvenido " + datos[0].nombre + "!",
            showConfirmButton: false,
            timer: 1200,
          }).then(() => {
            // Redirigir después de que el cuadro desaparezca
            var sessionAdmin = datos[0].nombreRol;
            
            if (sessionAdmin == "ADMIN") {
              window.location.href = "reportes.php";
            }else if (sessionAdmin == "RECLUTADOR") {
              window.location.href = "main.php";
            }else if (sessionAdmin == "POSTULANTE") {
              window.location.href = "main.php";
            }  
             //Redirigir a la pagina de PAOLA
            });
          break;

        case false:
            Swal.fire({
                icon: "error",
                title: "Error al iniciar sesión",
                text: "Usuario o contraseña incorrecta!",
              });
          break;
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud AJAX:", xhr.status, xhr.statusText);
      alert("Error inesperado al iniciar sesión");
    },
  });
});
document.getElementById("olvidasteContrasena").addEventListener("click", function () {
  
  Swal.fire({
    title: "¿Olvidaste tu contraseña?",
    text: "Ingresa tu correo electrónico para recuperar tu contraseña.",
    input: "email", // Campo para ingresar un correo electrónico
    inputAttributes: {
      autocapitalize: "off"
    },
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Enviar",
    showLoaderOnConfirm: true,
    preConfirm: async (email) => {
      try {
        // Redirige al controlador con el correo como parámetro
        //alert(email);
        $.ajax({
          url: "../controllers/UserController.php?op=enviarEmailContrasena&email=" + email,
          type: "GET",
          success: function (data) {
            console.log(email);
            Swal.fire({
              title: "Correo enviado!",
              text: "Te hemos enviado un correo electrónico con las instrucciones para recuperar tu contraseña.",
              icon: "success",
              confirmButtonText: "Aceptar",
              allowOutsideClick: () => !Swal.isLoading(),
            });
          },
          error: function (xhr, status, error) {
            Swal.showValidationMessage(`Error al enviar el correo: ${error}`);
          }
        });
      } catch (error) {
        Swal.showValidationMessage(`Error al redirigir: ${error}`);
      }
    },
    allowOutsideClick: () => !Swal.isLoading()
  }); 
});
