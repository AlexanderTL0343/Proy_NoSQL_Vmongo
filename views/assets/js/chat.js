/*
// Conectar al servidor WebSocket
let socket = new WebSocket('ws://localhost:8080'); // Cambia la URL si es necesario

// Elementos del DOM
let chatBox = document.getElementById('chat-box');
let messageInput = document.getElementById('message-input');
let sendMessageButton = document.getElementById('send-message');

// Manejar la conexión WebSocket abierta
socket.onopen = function(event) {
  console.log("Conexión WebSocket establecida");
};

// Manejar mensajes entrantes
socket.onmessage = function(event) {
  let message = event.data; // Mensaje recibido
  let messageElement = document.createElement('div');
  messageElement.classList.add('message-box', 'message-received');
  messageElement.textContent = message;
  chatBox.appendChild(messageElement);
  chatBox.scrollTop = chatBox.scrollHeight; // Desplazar al final del chat
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
    socket.send(message); // Enviar el mensaje al servidor
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
*/
//------------------------------------------------------------------------
//------------------------------------------------------------------------
$(document).ready(function () {
  listarChats();
});



function listarChats() {
  let idUsuarioActual = document.getElementById("idUserActual").getAttribute("data-idUser");
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
            generarCard(chat,idUsuarioActual).then(card => {
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

function generarCard(chat,idUsuarioActual) {
  let idChat = chat._id;
  let participantes = chat.participantes;

  return Promise.all([
    obtenerUsuario(participantes[0]),
    obtenerUsuario(participantes[1])
    
  ]).then(([usuario1, usuario2]) => {
    
    let userAux;

    switch (parseInt(idUsuarioActual)) {
      case usuario1._id:
        userAux = usuario2;
        break;
      case usuario2._id:
        userAux = usuario1;
        break;
    }

    return `
      <li class="list-group-item d-flex justify-content-between align-items-center p-2">
        <div class="d-flex align-items-center">
          <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <span>${userAux.nombreUsuario.charAt(0)}</span>
          </div>
          <div style="margin-left: 8px;">
            <h5 class="mb-0">${userAux.nombreUsuario}</h5>
            <small class="text-success">En línea</small>
          </div>
        </div>
        <button class="btn btn-outline-primary" type="button" id="${idChat}" data-chat="${JSON.stringify(userAux)}" style="font-size: 1rem;">
          <i class="bi bi-chat-fill"></i>
        </button>
      </li> 
    `;
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


document.getElementById("listaChats").addEventListener("click", function (event) {
  let boton = event.target.closest("button"); // Detecta si se hizo clic en un botón de chat
  if (boton) {
    //let idChat = boton.id; // Obtiene el ID del chat desde el atributo id del botón
    console.log("HOLA"+boton.id);
  }
});
