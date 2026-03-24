# 🚀 SkillMap - Sistema de Gerenciamento de Talentos

## 📌 Sobre o Projeto

O **SkillMap** é uma aplicação fullstack desenvolvida com o objetivo de mapear, organizar e conectar talentos por meio de suas competências técnicas. A plataforma permite que empresas, equipes ou comunidades identifiquem rapidamente profissionais com habilidades específicas, facilitando a colaboração e a tomada de decisões.

Com um dashboard interativo e busca dinâmica, o sistema oferece uma experiência fluida e eficiente para exploração de dados em tempo real.

---

## ✨ Funcionalidades

### 🔍 Dashboard & Busca Dinâmica

* **Filtro por Tags:**
  Cada habilidade no perfil é clicável, permitindo filtrar automaticamente profissionais com a mesma competência.

* **Pesquisa Global:**
  Sistema de busca inteligente via parâmetros GET, retornando resultados instantâneos.

* **Reset de Filtros:**
  Botão de "Tela Inicial" para limpar rapidamente os filtros aplicados.

---

### 🔐 Segurança & Autenticação

* **Proteção de Senhas:**
  Utilização de `password_hash` e `password_verify` com BCrypt.

* **Recuperação de Senha:**
  Sistema de redefinição via e-mail com tokens temporários.

* **Controle de Sessão:**
  Gerenciamento de acesso por níveis, evitando acessos indevidos via URL.

---

### 📧 Comunicação & Experiência do Usuário

* **Sistema de Mensagens:**
  Estrutura preparada para troca de mensagens entre usuários.

* **Alertas Flutuantes:**
  Feedback visual para ações (sucesso, erro, logout) com animações e temporizadores.

* **Interface Moderna:**
  Design com suporte a Dark Mode, priorizando legibilidade e usabilidade.

---

## 🛡️ Arquitetura & Boas Práticas

O projeto segue padrões modernos de desenvolvimento:

* **Repository Pattern:**
  Separação entre lógica de negócio e acesso a dados.

* **Variáveis de Ambiente:**
  Proteção de credenciais sensíveis através de arquivos externos (`config.php`).

* **SQL Seguro:**
  Uso de PDO com Prepared Statements para prevenir SQL Injection.

---

## 📁 Estrutura do Projeto

```
SkillMap/
├── database.sql        # Script do banco de dados
├── config.php          # Configurações sensíveis (ignorado no Git)
├── .gitignore          # Arquivos ignorados
├── controller/         # Regras de negócio e controle
├── model/              # Repositories e serviços
├── view/               # Interface (HTML/CSS/JS)
└── Includes/           # Bibliotecas externas (PHPMailer, etc)
```

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8.x
* **Banco de Dados:** MySQL / MariaDB
* **Envio de E-mails:** SMTP (PHPMailer)
* **Frontend:** HTML5, CSS3 (Flexbox, Grid, Transitions)
* **Servidor Local:** XAMPP / WAMP

---

## 🚀 Como Executar o Projeto

### 1. Clone o repositório

```bash
git clone https://github.com/GustavoMessiasDeAzevedo/SkillMapPHP.git
```

### 2. Configure o banco de dados

* Acesse o **phpMyAdmin**
* Importe o arquivo `database.sql`

### 3. Configure o ambiente

* Crie um arquivo `config.php` na raiz
* Baseie-se no `config.example.php`
* Insira:

  * Credenciais do banco
  * Configurações SMTP

### 4. Execute o projeto

* Mova a pasta para o diretório do servidor (ex: `htdocs` no XAMPP)
* Acesse no navegador:

```
http://localhost/SkillMap
```

---

## 🧠 Casos de Uso

* Mapeamento de competências em empresas
* Identificação de especialistas por tecnologia
* Formação de equipes técnicas
* Networking entre desenvolvedores

---

## 📈 Roadmap

* [ ] Chat em tempo real
* [ ] Upload de fotos de perfil com redimensionamento automático
* [ ] Geração de relatórios em PDF
* [ ] Sistema de recomendações por habilidades
* [ ] API REST para integração externa

---

## 🎓 Contexto Acadêmico

Projeto desenvolvido como parte do **Projeto Integrador** do curso **Técnico em Desenvolvimento de Sistemas - SENAC**.

**Desenvolvedor Principal:** Gustavo Azevedo
**Colaboradores:** Maycon Souza e Paulo Souza (Pesquisa e Requisitos)

---

## 🤝 Contribuição

Contribuições são bem-vindas!
Sinta-se à vontade para abrir uma *issue* ou enviar um *pull request*.

---

## 📄 Licença

Este projeto está sob a licença MIT.
Sinta-se livre para usar, modificar e distribuir.

---

## ⭐ Considerações Finais

O **SkillMap** é mais do que um sistema — é uma ferramenta estratégica para conectar pessoas através do que elas sabem fazer de melhor.

Se este projeto te ajudou, considere deixar uma ⭐ no repositório!
