<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require __DIR__ . '/../vendor/autoload.php';

class Server implements MessageComponentInterface {
    
    protected $clients;
    protected $rooms; // salaId => array de conexiones

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->rooms = []; // inicializa salas
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "Nueva Conexion! ({$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Conexion {$conn->resourceId} ha sido desconectada\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Ocurrio un error: {$e->getMessage()}\n";

        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if (!isset($data['type'])) return;

        switch ($data['type']) {
            case 'join':
                $roomId = $data['room'];
                $from->room = $roomId;

                if (!isset($this->rooms[$roomId])) {
                    $this->rooms[$roomId] = new \SplObjectStorage;
                }

                $this->rooms[$roomId]->attach($from);
                echo "Usuario {$from->resourceId} se unió a la sala $roomId\n";
                break;

            case 'message':
                $roomId = $from->room ?? null;

                if ($roomId && isset($this->rooms[$roomId])) {
                    foreach ($this->rooms[$roomId] as $client) {
                        if ($from !== $client) {
                            $client->send(json_encode([
                                'from' => $data['from'],
                                'room' => $roomId,
                                'mensaje' => $data['mensaje'],
                                'fecha' => $data['fecha'],
                                'hora' => $data['hora']
                            ]));
                        }
                    }
                }
                break;
        }
    }

}