🚀 Sistema de Gerenciamento de Talentos (SkillMap)
📌 Sobre o Projeto

O SkillMap é uma aplicação fullstack desenvolvida com o objetivo de mapear, organizar e conectar talentos por meio de suas competências técnicas.

A plataforma permite que empresas, equipes ou comunidades identifiquem rapidamente profissionais com habilidades específicas, facilitando a colaboração e a tomada de decisões.

Com um dashboard interativo e comunicação em tempo real, o sistema oferece uma experiência fluida e eficiente para a exploração de dados e networking.

✨ Funcionalidades
🔍 Dashboard & Busca Dinâmica
Filtro por Tags: Cada habilidade no perfil é clicável, permitindo filtrar automaticamente profissionais com a mesma competência.
Pesquisa Global: Sistema de busca inteligente via parâmetros GET, retornando resultados instantâneos.
Reset de Filtros: Botão de "Tela Inicial" para limpar rapidamente os filtros aplicados.
💬 Comunicação em Tempo Real (WebSocket)
Chat Instantâneo: Troca de mensagens sem necessidade de F5, utilizando o protocolo Ratchet.
Notificações Visuais: Badges (balões numéricos) que atualizam em tempo real ao receber novas mensagens.
Persistência: Histórico de conversas carregado dinamicamente do banco de dados.
🔐 Segurança & Autenticação
Proteção de Senhas: Utilização de password_hash e password_verify com BCrypt.
Controle de Sessão: Gerenciamento de acesso por níveis, evitando acessos indevidos via URL.
SQL Seguro: Uso de PDO com Prepared Statements para prevenir SQL Injection.
🛡️ Arquitetura & Boas Práticas
Repository Pattern: Separação clara entre a lógica de negócio e o acesso aos dados.
Feedback ao Usuário: Alertas flutuantes (Toast) para ações de sucesso, erro ou logout com animações suaves.
📁 Estrutura do Projeto
SkillMap/
├── bin/                # Script de inicialização do servidor WebSocket
├── ConexaoDB/          # Configurações de conexão PDO com o banco
├── controller/         # Regras de negócio e controle da aplicação
├── repository/         # Camada de persistência (MensagemRepository, ChatHandler)
├── model/              # Classes de representação de objetos (Mensagem, Usuario)
├── view/               # Interface do usuário (HTML/CSS/JS)
└── database.sql        # Script para criação das tabelas no MySQL
🛠️ Tecnologias Utilizadas
Backend: PHP 8.x
Real-time: Ratchet PHP (WebSockets)
Banco de Dados: MySQL / MariaDB
Frontend: JavaScript (Vanilla), HTML5, CSS3 (Flexbox/Grid)
Gerenciador de Pacotes: Composer
🚀 Como Executar o Projeto
1. Clone o repositório
git clone https://github.com/GustavoMessiasDeAzevedo/SkillMapPHP.git
2. Instale as dependências do Chat
composer install
3. Configure o banco de dados
Acesse o phpMyAdmin
Importe o arquivo database.sql disponível na raiz do projeto
4. Inicie os servidores
Mova a pasta para o htdocs (XAMPP)
Acesse: http://localhost/SkillMap

⚠️ Importante: Para o chat funcionar, abra o terminal na pasta do projeto e rode:

php bin/chat-server.php
🧠 Casos de Uso
Mapeamento de competências em empresas
Identificação de especialistas por tecnologia
Formação de equipes técnicas e networking
🎓 Contexto Acadêmico

Projeto desenvolvido como parte do Projeto Integrador do curso Técnico em Desenvolvimento de Sistemas - SENAC.

Desenvolvedor Principal: Gustavo Azevedo
Colaboradores: Maycon Souza e Paulo Souza (Pesquisa e Requisitos)
📄 Licença

Este projeto está sob a licença MIT.
Sinta-se livre para usar, modificar e distribuir.
