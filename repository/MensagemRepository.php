<?php

require_once "../ConexaoDB/conexaoDB.php";
require_once "../model/Mensagem.php";

class MensagemRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function enviarMensagem($remetenteId, $destinatarioId, $conteudo)
    {
        $sql = "INSERT INTO mensagens (id_remetente, id_destinatario, conteudo) VALUES (:remetente, :destinatario, :conteudo)";

        $stmtMensagem = $this->pdo->prepare($sql);
        $stmtMensagem->bindValue(':remetente', $remetenteId);
        $stmtMensagem->bindValue(':destinatario', $destinatarioId);
        $stmtMensagem->bindValue(':conteudo', $conteudo);

        return $stmtMensagem->execute();
    }

    public function buscarConversa($usuario1, $usuario2)
    {
        $sql = "SELECT * FROM mensagens 
                WHERE (id_remetente = :u1 AND id_destinatario = :u2)
                   OR (id_remetente = :u2 AND id_destinatario = :u1)
                ORDER BY data_envio ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':u1' => $usuario1, ':u2' => $usuario2]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarMensagensNaoLidas($meuId)
    {
        $sql = "SELECT COUNT(*) as total FROM mensagens 
            WHERE id_destinatario = :meuId AND lida = FALSE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':meuId' => $meuId]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    }

    public function marcarComoLidas($meuId, $destinatarioId)
    {
        $sql = "UPDATE mensagens SET lida = TRUE 
            WHERE id_remetente = :destinatarioId AND id_destinatario = :meuId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':meuId' => $meuId, ':destinatarioId' => $destinatarioId]);
    }

    public function buscarQuemMandouMensagens($meuId)
    {
        // Faz um JOIN com a tabela de usuários para pegar o nome de quem enviou
        $sql = "SELECT DISTINCT u.nome, u.id 
            FROM mensagens m
            JOIN usuarios u ON m.id_remetente = u.id
            WHERE m.id_destinatario = :meuId AND m.lida = 0";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':meuId' => $meuId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
