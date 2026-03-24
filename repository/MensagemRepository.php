<?php

require_once dirname(__DIR__) . '/ConexaoDB/conexaoDB.php';
require_once dirname(__DIR__) . "/model/Mensagem.php";

class MensagemRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function enviarMensagem($remetente_id, $destinatario_id, $conteudo)
    {
        $sql = "INSERT INTO mensagens (remetente_id, destinatario_id, conteudo) VALUES (:remetente, :destinatario, :conteudo)";

        $stmtMensagem = $this->pdo->prepare($sql);
        $stmtMensagem->bindValue(':remetente', $remetente_id);
        $stmtMensagem->bindValue(':destinatario', $destinatario_id);
        $stmtMensagem->bindValue(':conteudo', $conteudo);

        return $stmtMensagem->execute();
    }

    public function buscarConversa($usuario1, $usuario2)
    {
        $sql = "SELECT * FROM mensagens 
                WHERE (remetente_id = :u1 AND destinatario_id = :u2)
                   OR (remetente_id = :u2 AND destinatario_id = :u1)
                ORDER BY data_envio ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':u1' => $usuario1, ':u2' => $usuario2]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarMensagensNaoLidas($meuId)
    {
        $sql = "SELECT COUNT(*) as total FROM mensagens 
            WHERE destinatario_id = :meuId AND lida = FALSE";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':meuId' => $meuId]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    }

    public function marcarComoLidas($meuId, $destinatarioId)
    {
        $sql = "UPDATE mensagens SET lida = TRUE 
            WHERE remetente_id = :destinatarioId AND destinatario_id = :meuId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':meuId' => $meuId, ':destinatarioId' => $destinatarioId]);
    }

    public function buscarQuemMandouMensagens($meuId)
    {
        // Faz um JOIN com a tabela de usuários para pegar o nome de quem enviou
        $sql = "SELECT DISTINCT u.nome, u.id 
            FROM mensagens m
            JOIN usuarios u ON m.remetente_id = u.id
            WHERE m.destinatario_id = :meuId AND m.lida = 0";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':meuId' => $meuId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
