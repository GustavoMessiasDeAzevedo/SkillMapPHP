<?php

require_once "../ConexaoDB/conexaoDB.php";
require_once "../repository/MensagemRepository.php";
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'Não logado']);
    exit;
}

$remetenteId = $_SESSION['usuario_id'];
$destinatarioId = $_POST['destinatario_id'] ?? null;
$conteudo = trim($_POST['conteudo'] ?? '');

if ($destinatarioId && !empty($conteudo)) {
    $mensagemRepository = new MensagemRepository($pdo);
    $sucesso = $mensagemRepository->enviarMensagem($remetenteId, $destinatarioId, $conteudo);
    
    echo json_encode(['success' => $sucesso]);
} else {
    echo json_encode(['success' => false, 'error' => 'Dados incompletos']);
}
