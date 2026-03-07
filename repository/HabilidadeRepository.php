<?php

class HabilidadeRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function inserirUnicaEAssociar(string $nomeHabilidade, int $usuarioId):void{
        
        //Primeira parte do código, ele da um SELECT no banco de dados com o intuito de pesquisar se a habilidade ja existe limitando a 1 nome.
        $sqlBusca = 'SELECT id FROM habilidades WHERE nome=:nome LIMIT 1';
        $stmtBusca = $this->pdo->prepare($sqlBusca);
        $stmtBusca->bindValue(':nome', mb_strtolower($nomeHabilidade));
        $stmtBusca->execute();

        //PDO::FETCH_ASSOC pega os dados da primeira linha de busca e mostra como um array EX: "id" = 1, "nome" = "PhP"
        $habilidade = $stmtBusca->fetch(PDO::FETCH_ASSOC);

        //Nessa estrutura condicional ele verifica se a variavel $habilidade encontrou algum dado, se ele encontrou ele retorna o Id para realizar o insert na tabela habilidade_usuario, se não encontrou ele insere esse valor novo no banco de dados
        if($habilidade){
            $habilidadeId = (int)$habilidade['id'];
        }else{
            $sqlInsere = "INSERT INTO habilidades (nome) VALUES (:nome)";
            $stmtInsere = $this->pdo->prepare($sqlInsere);
            $stmtInsere->bindValue(':nome', mb_strtolower($nomeHabilidade));
            $stmtInsere->execute();

            //Pega o valor do Id gerado para a nova habilidade
            $habilidadeId = (int)$this->pdo->lastInsertId();
        }

        //Insert na tabela N:N de habilidade_usuario
        $sqlVinculo = "INSERT INTO habilidade_usuario (usuario_id, habilidade_id) VALUEs (:usuario_id, :habilidade_id) ";
        $stmtVinculo = $this->pdo->prepare($sqlVinculo);
        $stmtVinculo->bindValue(':usuario_id', $usuarioId);
        $stmtVinculo->bindValue(':habilidade_id', $habilidadeId);
        $stmtVinculo->execute();
    }
    // 1. Para listar todos os checkboxes na tela de edição
    public function listarTodas() {
        $sql = "SELECT id, nome FROM habilidades ORDER BY nome ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Para saber quais habilidades marcar como 'checked'
    public function buscarIdsPorUsuario(int $usuarioId) {
        $sql = "SELECT habilidade_id FROM habilidade_usuario WHERE usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario_id' => $usuarioId]);
        
        // O FETCH_COLUMN transforma o resultado em um array simples: [1, 2, 5]
        // Isso é essencial para o in_array($id, $habilidadesAtuais) funcionar
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}