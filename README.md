🚀 SkillMap - Sistema de Gerenciamento de Talentos
📌 Sobre o Projeto
O SkillMap é uma plataforma Fullstack desenvolvida para facilitar o mapeamento de competências técnicas dentro de uma organização ou comunidade. O sistema permite localizar profissionais através de suas habilidades, promovendo conexões diretas e visualização de dados em tempo real através de um dashboard interativo.

✨ Funcionalidades Principais
🔍 Dashboard & Busca Dinâmica
Filtro por Tags: Cada habilidade no perfil do usuário é um link funcional. Ao clicar, o sistema filtra automaticamente todos os profissionais com aquela expertise.

Pesquisa Global: Barra de busca inteligente via GET que processa termos e retorna resultados instantâneos.

Reset de Filtros: Botão "Tela Inicial" integrado para limpeza rápida de parâmetros de busca.

🔐 Segurança & Autenticação
Proteção de Senhas: Implementação de password_hash e password_verify (BCrypt).

Recuperação de Senha: Sistema via e-mail utilizando PHPMailer e tokens de verificação temporários.

Gestão de Sessão: Controle de acesso por níveis e proteção contra acessos indevidos via URL.

📧 Comunicação & UX
Sistema de Mensagens: Banco de dados preparado para troca de mensagens entre usuários.

Alertas Flutuantes: Feedback visual (Sucesso/Erro/Logout) com temporizadores e barras de progresso em CSS.

UI Moderna: Interface otimizada para Dark Mode, focada em legibilidade e experiência do usuário (UX).

🛡️ Boas Práticas & Arquitetura
O projeto segue padrões de mercado para garantir escalabilidade e segurança:

Repository Pattern: A lógica de acesso ao banco de dados é isolada da lógica de negócio.

Environment Variables: Proteção de credenciais sensíveis (SMTP/Banco) através de arquivos de configuração externos (config.php).

SQL Seguro: Todas as consultas utilizam PDO com Prepared Statements para anular riscos de SQL Injection.

📁 Estrutura de Pastas
Plaintext
SkillMap/
├── database.sql       # Script completo para criação do banco
├── config.php         # Configurações sensíveis (Ignorado no Git)
├── .gitignore         # Filtro de arquivos para o repositório
├── controller/        # Lógica de negócio e rotas
├── model/             # Classes de serviço e Repositories
├── view/              # Interfaces (HTML/CSS/JS)
└── Includes/          # Dependências externas (PHPMailer, etc)
🛠️ Tecnologias Utilizadas
Linguagem: PHP 8.x

Banco de Dados: MySQL (MariaDB)

Protocolo: SMTP (Gmail API) para disparos de e-mail.

Estilização: CSS3 (Flexbox/Grid/Transitions)

🚀 Como Instalar e Rodar
Clone o Repositório:

Bash
git clone https://github.com/GustavoMessiasDeAzevedo/SkillMapWEB.git
Configure o Banco de Dados:

Importe o arquivo database.sql no seu PHPMyAdmin.

Configure as Credenciais:

Crie um arquivo config.php na raiz baseado no config.example.php.

Insira suas credenciais de e-mail e banco de dados.

Acesse o Projeto:

Mova a pasta para o seu servidor local (XAMPP/WAMP) e acesse http://localhost/SkillMap.

📝 Próximos Passos (Roadmap)
[ ] Implementação de Chat em Tempo Real.

[ ] Upload de fotos de perfil com redimensionamento dinâmico.

[ ] Geração de relatórios de competências em PDF.