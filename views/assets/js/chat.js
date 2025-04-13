
// Conectar al servidor WebSocket
let socket = new WebSocket('ws://localhost:8080'); // Cambia la URL si es necesario

// Elementos del DOM
let chatBox = document.getElementById('chat-box');
let messageInput = document.getElementById('message-input');
let sendMessageButton = document.getElementById('send-message');
let currentChatId = null;

// Manejar la conexión WebSocket abierta
socket.onopen = function(event) {
  console.log("Conexión WebSocket establecida");
};

function obtenerChatActivo() {
  console.log($(document).getElementByClassName("listaChats"));
  return document.querySelector('.chat-element.active').dataset.chatId;
}

// Manejar la conexión WebSocket abierta
socket.onopen = function(event) {
  console.log("Conexión WebSocket establecida");
};

// Manejar mensajes entrantes
socket.onmessage = function(event) {
  let data = JSON.parse(event.data); // Convertir el mensaje a objeto
  let chatActivo = obtenerChatActivo();

  // Verificar si el mensaje pertenece al chat activo
  if (data.id_chat_fk === chatActivo) {
    let messageElement = document.createElement('div');
    messageElement.classList.add('message-box', data.id_emisor_fk == obtenerIdUsuarioActual() ? 'message-sent' : 'message-received');
    messageElement.textContent = data.mensaje;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight; // Desplazar al final del chat
  }
};

// Manejar errores
socket.onerror = function(error) {
  console.error("Error en WebSocket:", error);
};

// Manejar cierre de conexión
socket.onclose = function(event) {
  console.log("Conexión WebSocket cerrada");
};

// Enviar un mensaje
sendMessageButton.addEventListener('click', function() {
  let message = messageInput.value.trim();
  if (message) {
    let chatId = obtenerChatActivo();
    let data = {
      id_chat_fk: chatId,
      id_emisor_fk: obtenerIdUsuarioActual(),
      mensaje: message
    };
    socket.send(JSON.stringify(data)); // Enviar el mensaje como JSON

    let messageElement = document.createElement('div');
    messageElement.classList.add('message-box', 'message-sent');
    messageElement.textContent = message;
    chatBox.appendChild(messageElement);
    messageInput.value = ''; // Limpiar el campo de texto
    chatBox.scrollTop = chatBox.scrollHeight; // Desplazar al final del chat
  }
});

// Enviar mensaje con Enter
messageInput.addEventListener('keydown', function(event) {
  if (event.key === 'Enter') {
    sendMessageButton.click();
  }
});

//------------------------------------------------------------------------
//------------------------------------------------------------------------
$(document).ready(function () {
  listarChats();
  listarUsuarios();//se lista para agregar chats
});

/*
document.getElementById("listaChats").addEventListener("click", function (event) {
  let boton = event.target.closest("button"); // Detecta si se hizo clic en un botón de chat
  if (boton) {
    let userAux = JSON.parse(boton.dataset.chat); // Obtener y parsear el JSO
    mostrarChat(boton.id, userAux);
  }
});*/

document.getElementById("listaChats").addEventListener("click", function (event) {
  let boton = event.target.closest("button"); // Detecta si se hizo clic en un botón de chat
  if (boton && boton.classList.contains("btnVerCHAT")) { // Verifica que el botón tenga la clase correcta
    let userAux = JSON.parse(boton.dataset.chat); // Obtener y parsear el JSON
    mostrarChat(boton.id, userAux);
  }

  if (boton && boton.classList.contains("btnEliminarCHAT")) { // Verifica que el botón tenga la clase correcta
    let idChat= boton.dataset.id; // Obtener y parsear el JSON
    console.log(idChat);
    eliminarChat(idChat);
  }

});

function mostrarChat(idChat, usuarioDestino) {
  document.getElementById("chat-inicial").textContent = usuarioDestino.nombreUsuario.charAt(0);
  document.getElementById("chat-name").textContent = usuarioDestino.nombreUsuario;
  document.getElementById("chat-box").innerHTML = ""; // Limpia el chat anterior
  listarMensajes(idChat);
}

function listarChats() {
  let idUsuarioActual = document.getElementById("idUserActual").getAttribute("data-idUser");

  $("#listaChats").empty();

  $.ajax({
    url: "../controllers/chatsController.php?op=listarChats",
    type: "GET",
    data: { idUsuarioActual: idUsuarioActual },
    success: function (response) {
      response = JSON.parse(response);
      switch (response.status) {
        case true:
          //console.log(response.datos);
          response.datos.forEach(chat => {
            //console.log(chat);
            generarCard(chat, idUsuarioActual).then(card => {
              $("#listaChats").append(card);
            });
          });

          break;
        case false:
          Swal.fire({
            icon: "error",
            title: "Error al obtener los chats",
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
        title: "Error al listar los chats",
        text: "Revisa los errores y vuelve a intentarlo.",
        showConfirmButton: false,
        timer: 1800,
      });
    },
  });
}

function generarCard(chat, idUsuarioActual) {//idUsuarioActual es el id del remitente
  let idChat = chat._id;
  let participantes = chat.participantes;

  return Promise.all([
    obtenerUsuario(participantes[0]),
    obtenerUsuario(participantes[1])

  ]).then(([usuario1, usuario2]) => {

    let userAux;

    //evitamos pasar el id del usuario actual
    switch (idUsuarioActual) { //REVISAR EN CASO DE ERROR AL LISTAR CHATS
      case usuario1._id:
        userAux = usuario2;
        break;
      case usuario2._id:
        userAux = usuario1;
        break;
    }
    return `
      <li class="chat-element list-group-item d-flex justify-content-between align-items-center p-2" data-chatId="${idChat}">
        <div class="d-flex align-items-center">
          <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <span>${userAux.nombreUsuario.charAt(0)}</span>
          </div>
          <div style="margin-left: 8px;">
            <h5 class="mb-0">${userAux.nombreUsuario}</h5>
            <small class="text-success">En línea</small>
          </div>
        </div>
        <div>
        <button class="btn btn-outline-primary btnVerCHAT" type="button" id="${idChat}" data-chat="${JSON.stringify(userAux).replace(/"/g, "&quot;")}" style="font-size: 1rem;">
          <i class="bi bi-chat-dots"></i>
        </button>

        <button class="btn btn-outline-danger btnEliminarCHAT" type="button" data-id="${idChat}" style="font-size: 1rem;">
          <i class="bi bi-trash"></i>
        </button>
        </div>
      </li> 
    `;//NOTA: ES MALA PRACTICA PERO SE PASA EL USUARIO DE DESTINO COMO UN JSON EN VEZ DEL ID, ESTP PARA EVIAR CONSULTARLO A CADA RATO, ESTO EN EL BOTON/
    //SE PUEDE CAMBIAR YA QUE TENEMOS EL METODO DE OBTENER EL USUARIO ***EL JSON CON LOS DATOS SE VEN EN EL F12***
  });
}

function obtenerUsuario(idUsuario) {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "../controllers/UserController.php?op=obtenerUsuario",
      type: "GET",
      data: { id: idUsuario },
      success: function (response) {
        response = JSON.parse(response);
        //console.log(response.message);
        if (response.status) {
          resolve(JSON.parse(response.usuario)); // devuelve ususario como un JSON
        } else {
          reject("Error al obtener el usuario");
        }
      },
      error: function (err) {
        console.error("Error en la solicitud AJAX:", err);
        reject("Error en la solicitud AJAX");
      }
    });
  });
}

function listarMensajes(idChat) {

  let usuarioActual = document.getElementById("idUserActual").getAttribute("data-idUser");

  console.log(usuarioActual);

  $.ajax({
    url: "../controllers/chatsController.php?op=obtenerMensajes",
    type: "GET",
    data: { idChat: idChat },
    success: function (response) {
      response = JSON.parse(response);
      switch (response.status) {
        case true:
          //console.log(response.datos);

          agregarMensajesAlChat(response.datos, usuarioActual);

          break;
        case false:
          Swal.fire({
            icon: "error",
            title: "Error al obtener los mensajes",
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
        title: "Error al listar los mensajes",
        text: "Revisa los errores y vuelve a intentarlo.",
        showConfirmButton: false,
        timer: 1800,
      });
    },
  });
}

function agregarMensajesAlChat(mensajes, idUsuarioActual) {
  let chatBox = document.getElementById("chat-box");

  mensajes.forEach((mensaje) => {
    let messageElement = document.createElement("div");
    // Diferenciar si el mensaje fue enviado por el usuario actual o por otro
    if (String(mensaje.id_emisor_fk) === String(idUsuarioActual)) {
      messageElement.classList.add("message-box", "message-sent");
    } else {
      messageElement.classList.add("message-box", "message-received");
    }

    // Agregar el contenido del mensaje
    messageElement.textContent = mensaje.mensaje;
    chatBox.appendChild(messageElement);
  });

  // Desplazar al final del chat
  chatBox.scrollTop = chatBox.scrollHeight;
}

//---------------------------------------------------------------------------------------

function listarUsuarios() {
  $.ajax({
    url: "../controllers/UserController.php?op=listarUsuarios",
    type: "GET",
    success: function (response) {
      response = JSON.parse(response);
      switch (response.status) {
        case true:

          generarOpcionesUsuarios(response.datos);
          break;
        case false:
          Swal.fire({
            icon: "error",
            title: "Error al obtener los usuarios",
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
        title: "Error al listar los usuarios",
        text: "Revisa los errores y vuelve a intentarlo.",
        showConfirmButton: false,
        timer: 1800,
      });
    },
  });
}

function generarOpcionesUsuarios(arrayUsuarios) {
  let usuarioActual = document.getElementById("idUserActual").getAttribute("data-idUser");
  let html = "";
  arrayUsuarios.forEach(usuario => {
    if (usuario._id !== usuarioActual) {//IF PARA EVITAR AGREGAR EL USUARIO ACTUAL A LA LISTA DE USUARIOS PARA CREAR CHAT
      html += `<option value="${usuario._id}">${usuario.nombreUsuario}</option>`;
    }
  });
  document.getElementById("listaUsuariosChat").innerHTML = html;
}

//CREAR CHAT
$(document).ready(function () {
  $("#submitChat").on("click", function (e) {
    e.preventDefault();
    var formData = new FormData($("#nuevoChatForm")[0]);
    let idUsuarioActual = document.getElementById("idUserActual").getAttribute("data-idUser");
    formData.append("idUsuarioActual", idUsuarioActual);
    $.ajax({
      url: "../controllers/chatsController.php?op=insertarChat",
      type: "POST",
      data: formData,//id usuario actual sera el id del remitente
      contentType: false,
      processData: false,
      success: function (response) {
        response = JSON.parse(response);
        switch (response.status) {
          case true:
            Swal.fire({
              icon: "success",
              title: "Chat creado exitosamente",
              text: "¡Gracias por compartir tu trabajo!",
              showConfirmButton: false,
              timer: 1800,
            }).then(() => {
              listarChats();
              $('#nuevoChatModal').modal('hide');
            });
            break;

          case false:
            Swal.fire({
              icon: "error",
              title: "Error al crear el chat",
              text: "Revisa los errores y vuelve a intentarlo.",
              showConfirmButton: false,
              timer: 1800,
            });
            break;

          case "existente":
            Swal.fire({
              icon: "error",
              title: "Error al crear el chat",
              text: "Ya existe el chat",
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
          title: "Error al crear el chat",
          text: "Revisa los errores y vuelve a intentarlo.",
          showConfirmButton: false,
          timer: 1800,
        });
      },
    });
  });
});


// Eliminar chat
function eliminarChat(idChat){
  Swal.fire({
    title: '¿Estás seguro?',
    text: '¿Desea eliminar este chat?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../controllers/chatsController.php?op=eliminarChat",
        type: "GET",
        data: { id: idChat },
        success: function (response) {
          response = JSON.parse(response);
          console.log(response);

          switch (response.status) {
            case true:
              listarChats();
              break;
            case false:
              Swal.fire({
                icon: "error",
                title: "Error al eliminar el chat",
                text: "Revisa los errores y vuelve a intentarlo.",
                showConfirmButton: false,
                timer: 1800,
              });
              break;
          }
        },
        error: function (err) {
          console.error("Error en la solicitud AJAX:", err);
        }
      })
    }
  })
}