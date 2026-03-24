<?php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use MensagemRepository;

require_once __DIR__ . '/MensagemRepository.php';

class ChatHandler implements MessageComponentInterface{
    protected $clients;
    protected $users;
    private $repo;

    public function __construct($pdo)
    {
       $this->clients = new \SplObjectStorage;
       $this->users = [];
       $this->repo = new MensagemRepository($pdo);
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nova conexão aberta ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);

        if(isset($data->type) && $data->type ==='login'){
            $this->users[$data->usuario_id] = $from;
            echo "Usuário {$data->usuario_id} está online.\n";
            return;
        }

        if(isset($data->destinatario_id)){
            if(isset($this->users[$data->destinatario_id])){
                $this->users[$data->destinatario_id]->send(json_encode([
                    'remetente_id' => $data->remetente_id,
                    'conteudo' => $data->conteudo,
                    'horario' => date('H:i')
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        $idUsuario = array_search($conn, $this->users);
        if($idUsuario !== false){
            unset($this->users[$idUsuario]);
            echo "Usuário $idUsuario desconectou.\n";
        }
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}