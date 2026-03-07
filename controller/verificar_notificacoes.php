<?php

require_once "../ConexaoDB/conexaoDB.php";
require_once "../repository/MensagemRepository.php";
session_start();

header('Content-Type: application/json');

if (isset($_SESSION['usuario_id'])) {
    $meuId = $_SESSION['usuario_id'];
    $repo = new MensagemRepository($pdo);

    $total = $repo->contarMensagensNaoLidas($meuId);
    $remetentes = $repo->buscarQuemMandouMensagens($meuId);
    echo json_encode([
        'total' => (int)$total,
        'quem_mandou' => $remetentes
    ]);
} else {
    echo json_encode([
        'total' => 0,
        'quem_mandou' => []
    ]);
}