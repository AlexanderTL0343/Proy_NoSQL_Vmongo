<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<?php
include("./assets/fragmentos/head.php");
?>

<body>
<?php include("../config/session.php"); ?>

<Div id="idUserActual" data-idUser="<?php echo $_SESSION['usuario']['idUsuario']; ?>"></Div>

<div>
  <div class="container-fluid chat-container mt-4 p-0">
    <div class="chat-box-container">
      <!-- Lista de chats -->
      <div class="chat-list">
        <h4 class="p-2 m-0 bg-secondary text-white text-center">Chats</h4>
        <ul class="list-group" id="listaChats">
          <!-- Lista de usuarios de chat (sin cambios) -->
        </ul>
      </div>

      <!-- Chat seleccionado -->
      <div class="chat-content">
        <!-- Encabezado del chat -->
        <div class="chat-header d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
              <span>J</span>
            </div>
            <div>
              <h5 class="mb-0">Juan Pérez</h5>
              <small class="text-success">En línea</small>
            </div>
          </div>
        </div>

        <!-- Mensajes del chat -->
        <div id="chat-box" class="chat-box">
          <!-- Los mensajes se insertarán dinámicamente aquí -->
        </div>

        <!-- Área de entrada de mensaje -->
        <div class="chat-input">
          <div class="input-group">
            <input id="message-input" type="text" class="form-control" placeholder="Escribe un mensaje..." aria-label="Escribe un mensaje...">
            <button class="btn btn-primary ms-2" id="send-message" type="button">
              <i class="bi bi-send-fill"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include ("./assets/fragmentos/footer.php"); ?>
</body>

<?php include("./assets/fragmentos/scripts.php"); ?>

<!-- Cargar el archivo JS para WebSocket -->
<script src="./assets/js/chat.js"></script>
</html>
