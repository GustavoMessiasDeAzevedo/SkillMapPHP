<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\ChatHandler;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/ConexaoDB/conexaoDB.php';
require dirname(__DIR__) . '/repository/ChatHandler.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatHandler($pdo)
        )
    ),
    8888
);

echo "🚀 Servidor SkillMap bombando na porta 8080...\n";
$server->run();