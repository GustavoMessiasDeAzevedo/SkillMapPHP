<?php

class Usuario {
    // Apenas declaramos o que precisa de lógica específica aqui fora
    private string $senha = ''; 
    private ?string $habilidadesTexto = null;
    private ?int $id = null;

    // CONSTRUTOR "MÁGICO" (Property Promotion)
    // Ao colocar 'public' ou 'private' aqui dentro, o PHP já cria a propriedade na classe
    public function __construct(
        public string $nome = '',
        public string $email = '',
        public string $localizacao = ''
    ) {}

    // --- MÉTODOS DE LÓGICA (Mantemos igual) ---

    public function definirSenha(string $senhaPura): void {
        $this->senha = password_hash($senhaPura, PASSWORD_DEFAULT);
    }

    public function carregarHashBanco(string $hash): void {
        $this->senha = $hash;
    }

    public function verificarSenha(string $senhaPura): bool {
        return password_verify($senhaPura, $this->senha);
    }

    // --- ACESSO MANUAL ---
    // Como $nome, $email e $localizacao são PUBLIC, você não precisa de Get/Set pra eles.
    // Você acessa direto: $usuario->nome = "Fulano";
    
    // Precisamos de getters manuais apenas para os PRIVADOS:
    
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getSenha(): string { return $this->senha; }

    public function getHabilidadesTexto(): ?string { return $this->habilidadesTexto; }
    public function setHabilidadesTexto(?string $texto): void { $this->habilidadesTexto = $texto; }
}