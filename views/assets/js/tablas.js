/Funcion para limpieza de los formularios/
function limpiarForms() {
  $('#modulos_add').trigger('reset');
  $('#modulos_update').trigger('reset');
}

/Funcion para cancelacion del uso de formulario de modificación/
function cancelarForm() {
  limpiarForms();
  $('#formulario_add').show();
  $('#formulario_update').hide();
}

function cancelarFormPubli() {
  limpiarForms();
  $('#formulario_add_p').show();
  $('#formulario_update_p').hide();
}

function cancelarFormProfeInsert() {
  limpiarForms();
  $('#formulario_add_fi').show();
  $('#formulario_update_fi').hide();
}

function cancelarFormProfeMod() {
  limpiarForms();
  $('#formulario_add_fm').show();
  $('#formulario_update_fm').hide();
}

function cancelarFormCateInsert() {
  limpiarForms();
  $('#formulario_add_ci').show();
  $('#formulario_update_ci').hide();
}

function cancelarFormCateMod() {
  limpiarForms();
  $('#formulario_add_cm').show();
  $('#formulario_update_cm').hide();
}

function listarRolCrud() {
  tabla = $('#tblRolesCrud').dataTable({
    aProcessing: true,
    aServerSide: true,
    dom: 'Bfrtip',
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
    ajax: {
      url: '../controllers/TablaRolControllers.php?op=LlenarTablaRol',
      type: 'GET',
      dataType: 'json',
      dataSrc: 'aaData',

      error: function (e) {
        console.log(e.responseText);
      }
    },
    bDestroy: true,
    iDisplayLength: 5,
    columns: [
      { data: "0" },
      { data: "1" },

    ]
  });
}


function listarUserCrud() {
  tabla = $('#tblUserCrud').dataTable({
    aProcessing: true,
    aServerSide: true,
    dom: 'Bfrtip',
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
    ajax: {
      url: '../controllers/TablaUserControllers.php?op=LlenarTablaUser',
      type: 'GET',
      dataType: 'json',
      dataSrc: 'aaData',

      error: function (e) {
        console.log(e.responseText);
      }
    },
    bDestroy: true,
    iDisplayLength: 5,
    columns: [
      { data: "0" },
      { data: "1" },
      { data: "2" },
      { data: "3" },
      { data: "4" },
      { data: "5" },
      { data: "6" },
      { data: "7" },
      { data: "8" },
    ]
  });
}

function listarPubliCrud() {
  tabla = $('#tblPublicacionesCrud').dataTable({
    aProcessing: true,
    aServerSide: true,
    dom: 'Bfrtip',
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
    ajax: {
      url: '../controllers/TablaPubliControllers.php?op=LlenarTablaPubli',
      type: 'GET',
      dataType: 'json',
      dataSrc: 'aaData',

      error: function (e) {
        console.log(e.responseText);
      }
    },
    bDestroy: true,
    iDisplayLength: 5,
    columns: [
      { data: "0" },
      { data: "1" },
      { data: "2" },
      { data: "3" },
      { data: "4" },
      { data: "5" },
      { data: "6" },
      { data: "7" },
      { data: "8" },
    ]
  });
}


function listarCaliCrud() {
  tabla = $('#tblCalificacionesCrud').dataTable({
    aProcessing: true,
    aServerSide: true,
    dom: 'Bfrtip',
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
    ajax: {
      url: '../controllers/TablaCaliControllers.php?op=LlenarTablaCali',
      type: 'GET',
      dataType: 'json',
      dataSrc: 'aaData',

      error: function (e) {
        console.log(e.responseText);
      }
    },
    bDestroy: true,
    iDisplayLength: 5,
    columns: [
      { data: "0" },
      { data: "1" },
      { data: "2" },

    ]
  });
}
function listarProfeCrud() {
  tabla = $('#tblProfeCrud').dataTable({
    aProcessing: true,
    aServerSide: true,
    dom: 'Bfrtip',
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
    ajax: {
      url: '../controllers/TablaProfeController.php?op=LlenarTablaProfe',
      type: 'GET',
      dataType: 'json',
      dataSrc: 'aaData',

      error: function (e) {
        console.log(e.responseText);
      }
    },
    bDestroy: true,
    iDisplayLength: 5,
    columns: [
      { data: "0" },
      { data: "1" },
      { data: "2" },

    ]
  });
}


function listarEstadoCrud() {
  tabla = $('#tblestadoCrud').dataTable({
    aProcessing: true,
    aServerSide: true,
    dom: 'Bfrtip',
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
    ajax: {
      url: '../controllers/TablaEstController.php?op=LlenarTablaEstado',
      type: 'GET',
      dataType: 'json',
      dataSrc: 'aaData',

      error: function (e) {
        console.log(e.responseText);
      }
    },
    bDestroy: true,
    iDisplayLength: 5,
    columns: [
      { data: "0" },
      { data: "1" },
      { data: "2" }

    ]
  });
}

function listarCateCrud() {
  tabla = $('#tblcateCrud').dataTable({
    aProcessing: true,
    aServerSide: true,
    dom: 'Bfrtip',
    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
    ajax: {
      url: '../controllers/TablaCateController.php?op=LlenarTablaCate',
      type: 'GET',
      dataType: 'json',
      dataSrc: 'aaData',

      error: function (e) {
        console.log(e.responseText);
      }
    },
    bDestroy: true,
    iDisplayLength: 5,
    columns: [
      { data: "0" },
      { data: "1" },
      { data: "2" },
      { data: "3" },

    ]
  });
}



//CRUD USUARIOS
$(function () {
  $('#formulario_update').hide();
  listarUserCrud();
});

$('#tblUserCrud tbody').on(
  'click',
  'button[id="modificarUsuario"]',
  function () {
    var data = $('#tblUserCrud').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add').hide();
    $('#formulario_update').show();
    $('#Eid').val(data[0]);
    $('#Enombre').val(data[1]);
    $('#Eedad').val(data[2]);
    $('#Eemail').val(data[3]);
    $('#Eprofesion').val(data[4]);
    $('#Erol').val(data[6]);

    listarProfesiones();
    return false;
  }
);

$('#usuario_update').on('submit', function (event) {
  event.preventDefault();
  bootbox.confirm('¿Desea modificar los datos?', function (result) {
    if (result) {
      var formData = new FormData($('#usuario_update')[0]);
      $.ajax({

        url: '../controllers/TablaUserControllers.php?op=editar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
          switch (String(datos)) {
            case "0":
              alert('Error al modificar los datos');
              break;
            case "1":
              alert('Usuario actualizado exitosamente');
              location.reload();
              limpiarForms();
              $('#formulario_update').hide();
              $('#formulario_add').show();
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
 //INACTIVAR USUARIOS
 $('#tblUserCrud tbody').on('click', 'button[id="eliminarUsuario"]', function () {
  var data = $('#tblUserCrud').DataTable().row($(this).parents('tr')).data();
  var idUsuario = data[0]; // Supongamos que el ID está en la columna 0

  if (confirm("¿Estás seguro de que deseas eliminar al usuario?")) {
      $.ajax({
          url: '../controllers/TablaUserControllers.php?op=eliminar', 
          type: 'POST',
          data: { id: idUsuario }, 
          success: function (response) {
              var result = JSON.parse(response);
              if (result.status === 'success') {
                  alert(result.message);
                  $('#tblUserCrud').DataTable().ajax.reload(); 
              } else {
                  alert(result.message); 
              }
          },
          error: function (xhr, status, error) {
              alert('Hubo un error al eliminar el usuario.');
          }
      });
  }

  return false; 
});


//CRUD PUBLICACIONES
$(function () {
  $('#formulario_update_p').hide();
  listarPubliCrud();
});



$('#tblPublicacionesCrud tbody').on(
  'click',
  'button[id="modificarPubli"]',
  function () {
    var data = $('#tblPublicacionesCrud').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add_p').hide();
    $('#formulario_update_p').show();
    $('#Pid').val(data[0]);
    $('#Puser').val(data[1]);
    $('#Ptitulo').val(data[2]);
    $('#Pdescripcion').val(data[3]);
    $('#Pubicacion').val(data[5]);
    $('#Pprecio').val(data[6]);

    return false;
  }
);

$('#publi_update').on('submit', function (event) {
  event.preventDefault();
  bootbox.confirm('¿Desea modificar los datos?', function (result) {
    if (result) {
      var formData = new FormData($('#publi_update')[0]);
      $.ajax({

        url: '../controllers/TablaPubliControllers.php?op=editar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
          switch (String(datos)) {
            case "0":
              alert('Error al modificar los datos');
              break;
            case "1":
              alert('Publicacion actualizada exitosamente');
              location.reload();
              limpiarForms();
              $('#formulario_update_p').hide();
              $('#formulario_add_p').show();
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

//CRUD PROFESIONES
$(function () {
  $('#formulario_update_fi').hide();
  listarPubliCrud();
});



$('#tblProfeCrud').on('click', '#agregarProfe', function () {
  var data = $('#tblProfeCrud').DataTable().row($(this).parents('tr')).data();
  limpiarForms();
  $('#formulario_add_fi').hide();
  $('#formulario_update_fi').show();
  $('#Fid').val(data[0]);
  $('#Fnombre').val(data[1]);
  return false;
});


$('#profe_insert').on('submit', function (event) {
  event.preventDefault();
  bootbox.confirm('¿Desea insertar estos datos?', function (result) {
    if (result) {
      var formData = new FormData($('#profe_insert')[0]);
      $.ajax({

        url: '../controllers/TablaProfeController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
        
          switch (String(datos)) {
            case "0":
              alert('Error al insertar los datos');
              break;
            case "1":
              alert('Profesion insertada exitosamente');
              location.reload();
              limpiarForms();
              $('#formulario_update_fi').hide();
              $('#formulario_add_fi').show();
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

//MODIFICAR PROFESIONES
$(function () {
  $('#formulario_update_fm').hide();
  listarPubliCrud();
});

$('#tblProfeCrud tbody').on(
  'click',
  'button[id="modificarProfesion"]',
  function () {
    var data = $('#tblProfeCrud').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add_fm').hide();
    $('#formulario_update_fm').show();
    $('#Mid').val(data[0]);
    $('#Mnombre').val(data[1]);

    return false;
  }
);

$('#profe_update').on('submit', function (event) {
  event.preventDefault();
  bootbox.confirm('¿Desea modificar los datos?', function (result) {
    if (result) {
      var formData = new FormData($('#profe_update')[0]);
      $.ajax({

        url: '../controllers/TablaProfeController.php?op=editar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
      
          switch (String(datos)) {
            case "0":
              alert('Error al modificar los datos');
              break;
            case "1":
              alert('Publicacion actualizada exitosamente');
              location.reload();
              limpiarForms();
              $('#formulario_update_fm').hide();
              $('#formulario_add_fm').show();
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

//CRUD CATEGORIAS

$(function () {
  $('#formulario_update_ci').hide();
  listarCateCrud();
});



$('#tblcateCrud').on('click', '#agregarCate', function () {
  var data = $('#tblcateCrud').DataTable().row($(this).parents('tr')).data();
  limpiarForms();
  $('#formulario_add_ci').hide();
  $('#formulario_update_ci').show();
  $('#Cid').val(data[0]);
  $('#Cnombre').val(data[1]);
  $('#Cdescripcion').val(data[2]);
  return false;
});


$('#cate_insert').on('submit', function (event) {
  event.preventDefault();
  bootbox.confirm('¿Desea insertar estos datos?', function (result) {
    if (result) {
      var formData = new FormData($('#cate_insert')[0]);
      $.ajax({

        url: '../controllers/TablaCateController.php?op=insertar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
    
          switch (String(datos)) {
            case "0":
              alert('Error al insertar los datos');
              break;
            case "1":
              alert('Categoria insertada exitosamente');
              location.reload();
              limpiarForms();
              $('#formulario_update_ci').hide();
              $('#formulario_add_ci').show();
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

//MODIFICAR CATEGORIAS
$(function () {
  $('#formulario_update_cm').hide();
  listarCateCrud();
});



$('#tblcateCrud tbody').on(
  'click',
  'button[id="modificarCategoria"]',
  function () {
    var data = $('#tblcateCrud').DataTable().row($(this).parents('tr')).data();
    limpiarForms();
    $('#formulario_add_cm').hide();
    $('#formulario_update_cm').show();
    $('#CMid').val(data[0]);
    $('#CMnombre').val(data[1]);
    $('#CMdescripcion').val(data[2]);

    return false;
  }
);

$('#cate_update').on('submit', function (event) {
  event.preventDefault();
  bootbox.confirm('¿Desea modificar los datos?', function (result) {
    if (result) {
      var formData = new FormData($('#cate_update')[0]);
      $.ajax({

        url: '../controllers/TablaCateController.php?op=editar',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
          switch (String(datos)) {
            case "0":
              alert('Error al modificar los datos');
              break;
            case "1":
              alert('Categoria actualizada exitosamente');
              location.reload();
              limpiarForms();
              $('#formulario_update_cm').hide();
              $('#formulario_add_cm').show();
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

function listarProfesiones(){
  $.ajax({
    url: "../controllers/UserController.php?op=obtenerProfesiones",
    type: "GET",
    success: function (datos) {
      datos = JSON.parse(datos);
      switch (datos[0].status) {
        case true:
          console.log(dFatos[0].datos);

          const selectProfesion = document.getElementById("Eprofesion");
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

$(document).ready(function () {
  listarRolCrud();
});

$(document).ready(function () {
  listarUserCrud();
});

$(document).ready(function () {
  listarPubliCrud();
});

$(document).ready(function () {
  listarCaliCrud();
});

$(document).ready(function () {
  listarProfeCrud();
});

$(document).ready(function () {
  listarEstadoCrud();
});

$(document).ready(function () {
  listarCateCrud();
});


