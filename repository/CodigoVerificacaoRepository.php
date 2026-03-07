<?php

require_once __DIR__ . '/../model/Codigo_Verificacao.php';
require_once __DIR__ . '/../ConexaoDB/conexaoDB.php';

class CodigoVerificacaoRepository{
    private PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    

    public function inserirCódigo(Codigo_Verificacao $codigo){

        

        $expiraEm = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $sql = "INSERT INTO codigo_verificacao (usuario_id, codigo, expira_em, usado) VALUES (:usuario_id, :codigo, :expira_em, :usado)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $codigo->usuario_id);
        $stmt->bindValue(':codigo', $codigo->codigo);
        $stmt->bindValue(':expira_em', $expiraEm);
        $stmt->bindValue(':usado', $codigo->usado, PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function buscarPorCodigo($codigo){
        $sql = "SELECT * FROM codigo_verificacao WHERE codigo = :codigo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function marcarUsado($id){
        $sql = "UPDATE codigo_verificacao SET usado = TRUE WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}