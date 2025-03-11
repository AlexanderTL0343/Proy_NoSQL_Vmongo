
document.addEventListener("DOMContentLoaded", function () {
  $.ajax({
    url: "../controllers/GraficoControllers.php?op=getUsuariosPorRol",
    type: "POST",
    data: {},
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("Respuesta del servidor:", response); 
      response = JSON.parse(response);

      roles = [];
      cantidad = [];

      response.forEach(element => {
        roles.push(element.NOMBRE_ROL);
        cantidad.push(element.cantidad);
      });


      listarGrafUsuariosTot(roles, cantidad);
      
    },
    error: function (err) {
      console.error("Error en la solicitud AJAX:", err);
      alert("Error inesperado al obtener los datos");
    },
  });
});

function listarGrafUsuariosTot(nombres, datos) {
  // Gráfico de cantidad de usuarios
  const ctx2 = document.getElementById("graf-cantidadUsuarios");
  
  new Chart(ctx2, {
    type: "pie",
    data: {
      labels: nombres,
      datasets: [
        {
          label: "Usuarios",
          data: datos,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}
//---------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  $.ajax({
    url: "../controllers/GraficoControllers.php?op=getUsuariosPorEdad",
    type: "POST",
    data: {},
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("Respuesta del servidor:", response); 
      response = JSON.parse(response);

      edades =  [];
      cantidad = [];

      response.forEach(element => {
        edades.push(element.EDAD);
        cantidad.push(element.CANTIDAD);
      });

      listarGrafUsuariosEdad(edades, cantidad);
      
    },
    error: function (err) {
      console.error("Error en la solicitud AJAX:", err);
      alert("Error inesperado al obtener los datos");
    },
  });
});

function listarGrafUsuariosEdad(edades, datos) {
  // Gráfico de cantidad de usuarios
  const ctx3 = document.getElementById("graf-usuarioPorEdad");
  new Chart(ctx3, {
    type: "bar",
    data: {
      labels: edades,
      datasets: [
        {
          label: "Edad",
          data: datos,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}


//------------------------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  $.ajax({
    url: "../controllers/GraficoControllers.php?op=getEstadoPorUsuario",
    type: "POST",
    data: {},
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("Respuesta del servidor:", response); 
      response = JSON.parse(response);

      Estado =  [];
      Cantidad  = [];

      response.forEach(element => {
        Estado.push(element.NOMBRE_ESTADO);
        Cantidad.push(element.CANTIDAD);
      });

      listarGrafUsuariosEstado(Estado, Cantidad);
      
    },
    error: function (err) {
      console.error("Error en la solicitud AJAX:", err);
      alert("Error inesperado al obtener los datos");
    },
  });
});

function listarGrafUsuariosEstado(Estado, datos) {
  // Gráfico de cantidad de usuarios por profesion 
  const ctx3 = document.getElementById("graf-usuarioPorEstado");
  new Chart(ctx3, {
    type: "pie",
    data: {
      labels: Estado,
      datasets: [
        {
          label: "Estado",
          data: datos,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}
//-----------------------------------------------------------------------------------------

document.addEventListener("DOMContentLoaded", function () {
  $.ajax({
    url: "../controllers/GraficoControllers.php?op=getProfesionPorUsuario",
    type: "POST",
    data: {},
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("Respuesta del servidor:", response); 
      response = JSON.parse(response);

      profesion =  [];
      Cantidad  = [];

      response.forEach(element => {
        profesion.push(element.NOMBRE_PROFESION);
        Cantidad.push(element.CANTIDAD);
      });

      listarGrafUsuariosProfesion(profesion, Cantidad);
      
    },
    error: function (err) {
      console.error("Error en la solicitud AJAX:", err);
      alert("Error inesperado al obtener los datos");
    },
  });
});

function listarGrafUsuariosProfesion(profesion, datos) {
  // Gráfico de cantidad de usuarios por profesion 
  const ctx3 = document.getElementById("graf-usuarioPorProfe");
  new Chart(ctx3, {
    type: "bar",
    data: {
      labels: profesion,
      datasets: [
        {
          label: "Profesion",
          data: datos,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}
//--------------------------------------------------------------------------------------------------------------------------

document.addEventListener("DOMContentLoaded", function () {
  $.ajax({
    url: "../controllers/GraficoControllers.php?op=getPubliPorCate",
    type: "POST",
    data: {},
    contentType: false,
    processData: false,
    success: function (response) {
      console.log("Respuesta del servidor:", response); 
      response = JSON.parse(response);

      categoria =  [];
      Cantidad  = [];

      response.forEach(element => {
        categoria.push(element.NOMBRE_CATEGORIA);
        Cantidad.push(element.CANTIDAD);
      });

      listarGrafPublicacionCategoria(categoria, Cantidad);
      
    },
    error: function (err) {
      console.error("Error en la solicitud AJAX:", err);
      alert("Error inesperado al obtener los datos");
    },
  });
});

function listarGrafPublicacionCategoria(categoria, datos) {
  // Gráfico de cantidad de publicaciones por categoria 
  const ctx3 = document.getElementById("graf-publiPorCate");
  new Chart(ctx3, {
    type: "bar",
    data: {
      labels: categoria,
      datasets: [
        {
          label: "Categoria",
          data: datos,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}