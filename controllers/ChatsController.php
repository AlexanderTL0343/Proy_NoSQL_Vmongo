<?php
    session_start();
    require_once '../models/ChatsModel.php';

    switch ($_GET['op']) {
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
    }

?>