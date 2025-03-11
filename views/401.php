<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 401 - No Autorizado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e3f2fd; /* Color de fondo celeste claro */
            color: #0d47a1; /* Color del texto, un azul oscuro para contraste */
        }
        .error-container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Sombra suave para el contenedor */
            background-color: white; /* Fondo blanco para el contenedor del error */
        }
        .error-code {
            font-size: 6rem; /* Tamaño grande para el código de error */
            font-weight: bold;
        }
        .btn-custom {
            background-color: #0d47a1; /* Color personalizado para el botón */
            color: white; /* Color del texto del botón */
        }
        .btn-custom:hover {
            background-color: #1565c0; /* Color más oscuro al pasar el mouse */
        }
    </style>
</head>
<body>

<div class="error-container">
    <div class="error-code">401</div>
    <h1>No Autorizado</h1>
    <p>Lo sentimos, no tienes permiso para acceder a esta página.</p>
    <a href="../views/index.php" class="btn btn-custom">Regresar al Inicio</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>