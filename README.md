# 🚀 SkillMap - Gerenciador de Talentos e Habilidades

## 📌 Introdução

O **SkillMap** é um sistema de gerenciamento de perfis profissionais desenvolvido para mapear competências de usuários.  

Com ele, é possível:

- Cadastrar profissionais  
- Vincular múltiplas habilidades técnicas  
- Gerenciar informações em tempo real  
- Utilizar uma interface moderna e responsiva  

O projeto foi construído com foco em organização de código, segurança e experiência do usuário.

---

## ✨ Funcionalidades

### 🔐 Autenticação Completa
- Sistema de login seguro  
- Proteção de sessões  
- Controle de acesso  

### 👤 CRUD de Usuários
- Cadastro de perfis  
- Edição de informações  
- Visualização de usuários  
- Exclusão (Delete) de registros  

### 🧩 Gestão de Habilidades (N:N)
- Vinculação dinâmica de múltiplas habilidades a um único usuário  
- Uso de tabelas associativas (pivot) no banco de dados  
- Relacionamento Muitos-para-Muitos (N:N)  

### 💬 Interface Interativa
- Notificações flutuantes  
- Barra de progresso para feedback visual  
- Mensagens de sucesso, erro e logout  

### 🛡️ Segurança
- Uso de `password_hash` para armazenamento seguro de senhas  
- Proteção contra acessos indevidos via URL  
- Conexões seguras com PDO  

---

## 🛠️ Tecnologias Utilizadas

### Backend
- PHP 8.x

### Banco de Dados
- MySQL  
- PDO para conexões seguras  

### Frontend
- HTML5  
- CSS3 (Modern UI)  
- JavaScript Vanilla  

---

## 🏗️ Arquitetura

O projeto segue boas práticas de organização:

- **Padrão Repository** → Separação da lógica de acesso a dados  
- **Controller** → Responsável pela lógica de negócio  
- Separação clara entre backend e frontend  

---

## 🚀 Instalação

Clone o repositório:
git clone https://github.com/GustavoMessiasDeAzevedo/SkillMapWEB.git
