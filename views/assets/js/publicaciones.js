/*document.getElementById("submitJob").addEventListener("click", function () {
  const jobTitle = document.getElementById("jobTitle").value;
  const jobDescription = document.getElementById("jobDescription").value;
  const jobPrice = document.getElementById("jobPrice").value;

  if (jobTitle && jobDescription && jobPrice) {
    // Crear una nueva tarjeta con la información del trabajo
    const newJobCard = document.createElement("div");
    newJobCard.classList.add("col", "mb-5");
    newJobCard.setAttribute("data-category", "nueva-postulacion"); // Puedes cambiar esto según sea necesario
    newJobCard.innerHTML = `
<div class="card h-100">
    <div class="card-body p-4">
        <div class="text-center">
            <h5 class="fw-bolder">${jobTitle}</h5>
            <p>${jobDescription}</p>
            <p>$${jobPrice}</p>
        </div>
    </div>
    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
        <div class="text-center">
            <a class="btn btn-outline-dark mt-auto" href="#" data-bs-toggle="modal" data-bs-target="#applicationModal">Ver empleo</a>
        </div>
    </div>
</div>
`;

    // Agregar la nueva tarjeta al contenedor de trabajos
    document.getElementById("jobContainer").appendChild(newJobCard);

    // Limpiar los campos del formulario
    document.getElementById("postJobForm").reset();

    // Cerrar el modal
    const modal = bootstrap.Modal.getInstance(
      document.getElementById("postJobModal")
    );
    modal.hide();
  } else {
    alert("Por favor, completa todos los campos.");
  }
});

document
  .getElementById("submitApplication")
  .addEventListener("click", function () {
    // Obtener los valores de los campos
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const message = document.getElementById("message").value;

    // Validar que los campos no estén vacíos
    if (name && email && message) {
      // Mostrar el mensaje de éxito
      const responseMessage = document.getElementById("responseMessage");
      responseMessage.style.display = "block";
      responseMessage.innerText = "¡Postulación enviada con éxito!";

      // Limpiar los campos del formulario
      document.getElementById("applicationForm").reset();
    } else {
      // Mostrar un mensaje de error si los campos están vacíos
      const responseMessage = document.getElementById("responseMessage");
      responseMessage.style.display = "block";
      responseMessage.classList.remove("alert-success");
      responseMessage.classList.add("alert-danger");
      responseMessage.innerText = "Por favor, completa todos los campos.";
    }
  });*/

  function filterProducts() {
    const filterValue = document.getElementById("categoryFilter").value;
    const products = document.querySelectorAll(".col");
  
    products.forEach((product) => {
      if (
        filterValue === "all" ||
        product.getAttribute("data-category") === filterValue
      ) {
        product.style.display = "block"; // Muestra el producto
      } else {
        product.style.display = "none"; // Oculta el producto
      }
    });
  }
  //----------------------------------------------------------------------------------------------------------------
  //BRANDON
  
  function listarTrasActualizar() {
    var metodo = "listarPublicaciones($publicaciones);";
  }
  
  function limpiarFormAgregar(){
      document.getElementById("titulo").value = "";
      document.getElementById("descripcion").value = "";
      document.getElementById("categoriaPublicacionSelect").value = "";
      document.getElementById("ubicacion").value = "";
      document.getElementById("precio").value = "";   
  }
  
  //metodo para insertar una nueva publicacion
  document.getElementById("subirTrabajo").addEventListener("click", function (e) {
      e.preventDefault();
      var formData = new FormData($("#formPostularTrabajo")[0]);
      $.ajax({
        url: "../controllers/publicacionController.php?op=insertarPublicacion",
        type: "POST",
        data: formData,
        processData: false, // Necesario para enviar FormData
        contentType: false, // Necesario para enviar FormData
        success: function (data) {
          data = JSON.parse(data);
  
          switch (data[0].status) {
            case true:
              Swal.fire({
                icon: "success",
                title: "Publicación creada exitosamente",
                showConfirmButton: false,
                timer: 1800,
              }).then(() => {
                document.getElementById("formPostularTrabajo").reset()});
                $('#postJobModal').modal('hide')
              break;
              case false:
                Swal.fire({
                  icon: "error",
                  title: "Error al crear la publicación",
                  showConfirmButton: false,
                  timer: 1800,
                });
              break;
          }
        },
      });
    });