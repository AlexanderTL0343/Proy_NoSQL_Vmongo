<?php
    session_start();
    require_once '../models/ChatsModel.php';

    switch ($_GET['op']) {
        case 'insertarChat':
            $chat = new Chat();
            $destinatario = isset($_POST['destinatario']) ? trim($_POST['destinatario']) : 0;
            $idUsuarioActual = isset($_POST['idUsuarioActual']) ? trim($_POST['idUsuarioActual']) : 0;

            if (is_numeric($destinatario)) {
                $destinatario = (int) $destinatario;
            } else {
                // Si el id no es numérico, convertirlo a ObjectId
                $destinatario = new \MongoDB\BSON\ObjectId($destinatario);
            }

            if (is_numeric($idUsuarioActual)) {
                $idUsuarioActual = (int) $idUsuarioActual;
            } else {
                // Si el id no es numérico, convertirlo a ObjectId
                $idUsuarioActual = new \MongoDB\BSON\ObjectId($idUsuarioActual);
            }

            $participantes = [$destinatario, $idUsuarioActual];

            //validar si el chat ya existe
            if ($chat->validarChatExistente($participantes) == true) {
                $response = [
                    "status" => "existente",
                    "message" => "Error al crear el chat: ya existe el chat"
                ];
                echo json_encode($response);
                break;
            }

            $chat->setParticipantes($participantes);
            $res = $chat->insertarChat();

            if($res){
                $response = [
                    "status" => true,
                    "message" => "Chat creado exitosamente",
                    "participantes" => $participantes
                ];
            }else{
                $response = [
                    "status" => false,
                    "message" => "Error al crear el chat"
                ];
            }

            echo json_encode($response);
            break;
        case 'listarChats':
            $chat = new Chat();
            $res = $chat->listarChats($_GET['idUsuarioActual']);

            //$response = array();
            $response = [
                "status" => true,
                "message" => "Chats obtenidos",
                "datos" => $res
            ];

            echo json_encode($response);
            break;
        
        case 'obtenerChat':
            $chat = new Chat();
            $res = $chat->obtenerChat($_GET['id']);

            //$response = array();
            $response = [
                "status" => true,
                "message" => "Chat obtenido",
                "chat" => $res
            ];

            echo json_encode($response);
            break;

        case 'obtenerMensajes':
            $chat = new Chat();
            $res = $chat->obtenerMensajes($_GET['idChat']);

            if($res){
                $response = array();
                $response = [
                    "status" => true,
                    "message" => "Mensajes obtenidos",
                    "datos" => $res
                ];
            }else{
                $response = array();
                $response = [
                    "status" => false,
                    "message" => "Error al obtener los mensajes"
                ];
            }

            echo json_encode($response);
            break;
    }

?>