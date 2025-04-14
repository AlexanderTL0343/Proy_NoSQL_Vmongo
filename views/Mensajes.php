<?php session_start();
include("./assets/fragmentos/sinSesion401.php");
?>
<!DOCTYPE html>
<html lang="es">

<?php
include("./assets/fragmentos/head.php");
?>

<body>
  <?php include("../config/session.php"); ?>

  <Div id="idUserActual" data-idUser="<?php echo $_SESSION['usuario']['idUsuario']; ?>" hidden></Div>

  <div>
    <div class="container-fluid chat-container mt-4 p-0">
      <div class="chat-box-container">
        <!-- Lista de chats -->
        <div class="chat-list">
          <div class="d-flex justify-content-between align-items-center p-3 bg-secondary text-white">
            <h4 class="m-0">Chats</h4>
            <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" id="btn-nuevo-chat" data-bs-toggle="modal" data-bs-target="#nuevoChatModal">
              <i class="bi bi-plus-lg"></i>
            </button>
          </div>

          <ul class="list-group listaChats" id="listaChats">
            <!-- Lista de usuarios de chat (sin cambios) -->
          </ul>
        </div>

        <!-- Chat seleccionado -->
        <div class="chat-content">
          <!-- Encabezado del chat -->
          <div class="chat-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
              <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <span id="chat-inicial"></span>
              </div>
              <div>
                <h5 class="mb-0" id="chat-name"></h5>
                <small class="text-success" id="chat-status"></small>
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
              
              <button class="btn btn-secondary ms-2" id="actualizar-mensaje" type="button" title="Actualizar mensajes">
                <i class="bi bi-arrow-repeat"></i>
              </button>
              
              <button class="btn btn-primary ms-2" id="send-message" type="button">
                <i class="bi bi-send-fill"></i>
              </button>
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<!--MODAL PARA CREAR NUEVO CHAT-->
<div class="modal fade" id="nuevoChatModal" tabindex="-1" aria-labelledby="nuevoChatModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="nuevoChatModal">Nuevo Chat</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="nuevoChatForm">
            <select name="destinatario" id="listaUsuariosChat" class="form-select form-control fs-5" size="5" aria-label="Usuarios" required>
              <!-- Lista de usuarios -->
            </select>
        </form>
      </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" id="submitChat"  class="btn btn-primary">Crear</button>
          </div>
    </div>
  </div>
</div>

  <?php include("./assets/fragmentos/footer.php"); ?>
</body>

<?php include("./assets/fragmentos/scripts.php"); ?>

<!-- Cargar el archivo JS para WebSocket -->
<script src="./assets/js/chat.js"></script>

</html>