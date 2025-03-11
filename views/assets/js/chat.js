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
