<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<?php
include("./assets/fragmentos/head.php");
?>

<body>
<?php include("../config/session.php");?>

<div>

<div class="container-fluid chat-container p-0">
    <div class="chat-box-container">
      <!-- Lista de chats -->
      <div class="chat-list">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action active d-flex align-items-center">
            <div class="d-flex align-items-center">
              <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <span>J</span>
              </div>
              <div>
                <h6 class="mb-0">Juan Pérez</h6>
                <small class="text-muted">En línea</small>
              </div>
            </div>
          </a>
          <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
            <div class="d-flex align-items-center">
              <div class="avatar bg-success text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <span>M</span>
              </div>
              <div>
                <h6 class="mb-0">María García</h6>
                <small class="text-muted">Hace 5 min</small>
              </div>
            </div>
          </a>
          <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
            <div class="d-flex align-items-center">
              <div class="avatar bg-info text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <span>C</span>
              </div>
              <div>
                <h6 class="mb-0">Carlos Rodríguez</h6>
                <small class="text-muted">Hace 1 hora</small>
              </div>
            </div>
          </a>
          <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
            <div class="d-flex align-items-center">
              <div class="avatar bg-warning text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <span>L</span>
              </div>
              <div>
                <h6 class="mb-0">Laura Sánchez</h6>
                <small class="text-muted">Ayer</small>
              </div>
            </div>
          </a>
          <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
            <div class="d-flex align-items-center">
              <div class="avatar bg-danger text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <span>A</span>
              </div>
              <div>
                <h6 class="mb-0">Alejandro Martínez</h6>
                <small class="text-muted">Hace 2 días</small>
              </div>
            </div>
          </a>
        </div>
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
          <div>
            <button class="btn btn-light rounded-circle me-1" title="Llamada de voz">
              <i class="bi bi-telephone"></i>
            </button>
            <button class="btn btn-light rounded-circle me-1" title="Videollamada">
              <i class="bi bi-camera-video"></i>
            </button>
            <button class="btn btn-light rounded-circle" title="Más opciones">
              <i class="bi bi-three-dots-vertical"></i>
            </button>
          </div>
        </div>

        <!-- Mensajes del chat -->
        <div class="chat-box">
          <div class="message-box message-received">
            ¡Hola! ¿Cómo estás hoy?
          </div>
          <div class="message-box message-sent">
            ¡Hola Juan! Estoy muy bien, gracias por preguntar. ¿Y tú qué tal?
          </div>
          <div class="message-box message-received">
            Todo bien por aquí. ¿Pudiste revisar los documentos que te envié ayer?
          </div>
          <div class="message-box message-sent">
            Sí, ya los revisé. Me parecen muy interesantes, especialmente la propuesta para el nuevo proyecto.
          </div>
          <div class="message-box message-received">
            ¡Genial! ¿Podríamos reunirnos mañana para discutirlo más a fondo?
          </div>
          <div class="message-box message-sent">
            Claro, estoy disponible por la tarde. ¿Te parece bien a las 15:00?
          </div>
        </div>

        <!-- Área de entrada de mensaje -->
        <div class="chat-input">
          <div class="input-group">
            <button class="btn btn-outline-secondary rounded-circle me-2" type="button">
              <i class="bi bi-emoji-smile"></i>
            </button>
            <button class="btn btn-outline-secondary rounded-circle me-2" type="button">
              <i class="bi bi-paperclip"></i>
            </button>
            <input type="text" class="form-control" placeholder="Escribe un mensaje..." aria-label="Escribe un mensaje...">
            <button class="btn btn-primary ms-2" type="button">
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
</html>