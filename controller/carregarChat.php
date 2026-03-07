<?php

require_once "../ConexaoDB/conexaoDB.php";
require_once "../repository/MensagemRepository.php";
session_start();

header('Content-Type: application/json'); //Serve para avisar que é um arquivo JSON

if (!isset($_SESSION['usuario_id']) || !isset($_GET['destinatario'])) {
    echo json_encode([]);
    exit;
}

$mensagemRepository = new MensagemRepository($pdo);

$meuId = $_SESSION['usuario_id'];
$destinatarioId = $_GET['destinatario'];

$conversa = $mensagemRepository->buscarConversa($meuId, $destinatarioId);
$mensagemRepository->marcarComoLidas($meuId, $destinatarioId);

echo json_encode($conversa);