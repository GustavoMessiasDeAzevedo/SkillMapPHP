<?php

require_once '../ConexaoDB/conexaoDB.php';
require_once '../model/Usuario.php';

class UsuarioRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this ->pdo = $pdo;
    }

    public function Inserir(Usuario $usuario){
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, localizacao) VALUES (:nome, :email, :senha_hash, :localizacao)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nome', $usuario->nome);
        $stmt->bindValue(':email', $usuario->email);
        $stmt->bindValue(':senha_hash', $usuario ->getsenha());
        $stmt->bindValue(':localizacao', $usuario->localizacao);
        $stmt->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function buscarEmail(string $email){
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarUsuario($termo = null, $minhaLocalizacao = null){
        $sql = "SELECT 
                u.id, 
                u.nome, 
                u.email, 
                u.localizacao,
                GROUP_CONCAT(h.nome) as habilidades 
            FROM usuarios u
            LEFT JOIN habilidade_usuario hu ON u.id = hu.usuario_id
            LEFT JOIN habilidades h ON hu.habilidade_id = h.id
            GROUP BY u.id";
        if($termo){
            $sql .= " HAVING habilidades LIKE :termo";
        }
        if($minhaLocalizacao){
            $sql .= " ORDER BY (u.localizacao = :minha_localizacao) DESC, u.nome ASC";
        }else{
            $sql .= " ORDER BY u.nome ASC";
        }
        $stmt = $this->pdo->prepare($sql);
        if($termo){
            $stmt->bindValue(':termo', '%'.$termo.'%');
        }
        if($minhaLocalizacao){
            $stmt->bindValue(':minha_localizacao', trim($minhaLocalizacao));
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id){
        $sql = "SELECT
                    u.id, u.nome, u.email, u.localizacao,
                    GROUP_CONCAT(h.nome) as habilidades
                FROM usuarios u
                LEFT JOIN habilidade_usuario hu ON u.id = hu.usuario_id
                LEFT JOIN habilidades h ON hu.habilidade_id = h.id
                WHERE u.id = :id
                GROUP BY u.id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarHabilidades(int $usuarioId, array $habilidadesId){
        try{
            $this->pdo->beginTransaction();
            //Remove todas as habilidades
            $sqlDelete = "DELETE FROM habilidade_usuario WHERE usuario_id = :usuario_id";
            $stmtDelete = $this->pdo->prepare($sqlDelete);
            $stmtDelete->execute(['usuario_id' => $usuarioId]);

            $sqlInsert = "INSERT INTO habilidade_usuario (usuario_id, habilidade_id) VALUES (:usuario_id, :habilidade_id)";
            $stmtInsert = $this->pdo->prepare($sqlInsert);

            foreach($habilidadesId as $habId){
                $stmtInsert->execute([
                    ':usuario_id' => $usuarioId,
                    ':habilidade_id' => $habId
                ]);
            }
            return $this->pdo->commit();
        }catch (Exception $e) {
        $this->pdo->rollBack();
        return false;
        }
    }

    public function atualizarDadosUsuario($id, $nome, $email, $localizacao){
        $sql = "UPDATE usuarios
                SET nome = :nome, email = :email, localizacao = :localizacao
                WHERE id = :id";
        $stmtUpdate = $this->pdo->prepare($sql);
        $stmtUpdate->bindValue(':nome', $nome);
        $stmtUpdate->bindValue(':email', $email);
        $stmtUpdate->bindValue(':localizacao', $localizacao);
        $stmtUpdate->bindValue(':id', $id);
        return $stmtUpdate->execute();
    }

    public function deletarDadosUsuario($id){
        try{
            $sqlHab = "DELETE FROM habilidade_usuario WHERE usuario_id = :id";
            $stmtHab = $this->pdo->prepare($sqlHab);
            $stmtHab->execute([':id' => $id]);

            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmtDelete = $this->pdo->prepare($sql);
            $stmtDelete->bindValue(':id', $id);
            return $stmtDelete->execute();
        }catch(Exception $e){
            $this->pdo->rollBack();
            return false;
        }
        
    }

    public function atualizarSenha($id, $novaSenha){
        $usuario = new Usuario();
        $usuario->definirSenha($novaSenha);
        $sql = "UPDATE usuarios SET senha_hash = :senha_hash WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':senha_hash', $usuario->getSenha());
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

}