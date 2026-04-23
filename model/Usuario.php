<?php

class Usuario {

    private string $senha = ''; 
    private ?string $habilidadesTexto = null;
    private ?int $id = null;

    public function __construct(
        public string $nome = '',
        public string $email = '',
        public string $localizacao = ''
        
    ) {}


    public function definirSenha(string $senhaPura): void {
        $this->senha = password_hash($senhaPura, PASSWORD_DEFAULT);
    }

    public function carregarHashBanco(string $hash): void {
        $this->senha = $hash;
    }

    public function verificarSenha(string $senhaPura): bool {
        return password_verify($senhaPura, $this->senha);
    }

    
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getSenha(): string { return $this->senha; }

    public function getHabilidadesTexto(): ?string { return $this->habilidadesTexto; }
    public function setHabilidadesTexto(?string $texto): void { $this->habilidadesTexto = $texto; }
}
