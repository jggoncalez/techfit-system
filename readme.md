# TechFit System

<p align="center">
  <img src="public/images/logo-fixed.webp" alt="TechFit Logo" width="200">
</p>



<p align="center">
  <strong>Sistema de Gerenciamento de Academia Automatizado</strong><br>
  Gestão inteligente de treinos, acessos e agendamentos com tecnologia IoT
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white" alt="Chart.js">
  <img src="https://img.shields.io/badge/Arduino-00979D?style=for-the-badge&logo=arduino&logoColor=white" alt="Arduino">
</p>

---

## 📋 Índice

- [Sobre o Projeto](#-sobre-o-projeto)
- [Funcionalidades](#-funcionalidades)
- [Páginas do Sistema](#-páginas-do-sistema)
- [Arquitetura e Design](#-arquitetura-e-design)
- [Tecnologias Utilizadas](#-tecnologias-utilizadas)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Instalação](#-instalação)
- [Contribuidores](#-contribuidores)

---

## 🎯 Sobre o Projeto
<p align="center">
    <img src=".github/main-page-screenshot.png" alt="Main Page">
</p>

A **TechFit** é um sistema completo de gerenciamento de academia que integra tecnologia IoT para controle de acesso via RFID, sistema de gestão completo para academias e dashboards analíticos em tempo real.

O sistema foi desenvolvido para atender três tipos de usuários: **visitantes** (página pública), **alunos** (área do usuário) e **funcionários** (painel administrativo).

### 🌟 Diferenciais

- **Controle de Acesso IoT**: Integração com Arduino + RFID para entrada automatizada na academia
- **Dashboard Analytics**: Gráficos e métricas em tempo real para gestão eficiente
- **Montagem simples e fácil de treinos**: Interface intuitiva para criação e personalização de programas de exercícios

---

## ✨ Funcionalidades

### 🔐 Controle de Acesso
- Leitura de cartões RFID com Arduino MFRC522
- Registro automático de entradas e saídas
- Validação de status de pagamento em tempo real
- Histórico completo de acessos

### 📊 Dashboard Analítico
- Estatísticas gerais (usuários ativos, treinos, receita)
- Gráfico de distribuição de planos
- Evolução de treinos por mês
- Pontuação por grupos musculares
- Ranking de exercícios mais utilizados
- Próximas aulas agendadas

### 📅 Agendamento de Aulas
- Cadastro de aulas em grupo
- Controle de vagas disponíveis
- Inscrição de alunos
- Gestão de instrutores

### 👥 Gestão de Usuários
- Cadastro completo de alunos
- Dados físicos do aluno
- Histórico de treinos
- Controle de planos e pagamentos

---

## 📱 Páginas do Sistema

### Área Pública

| Rota | Descrição |
|------|-----------|
| `/` | Home page com apresentação, planos e academias próximas |
| `/academias` | Lista completa de unidades TechFit |
| `/login` | Autenticação de usuários e funcionários |

### Área do Funcionário

| Rota | Descrição |
|------|-----------|
| `/funcionario` | Dashboard principal com analytics |
| `/funcionario/register/exercicios` | Cadastro de novos exercícios |
| `/funcionario/register/estudantes` | Cadastro de alunos |
| `/funcionario/register/classes` | Cadastro de aulas em grupo |
| `/funcionario/register/treino` | Montagem de treinos personalizados |
| `/funcionario/RFID` | Monitor de leituras RFID |

### Área do Usuário

| Rota | Descrição |
|------|-----------|
| `/usuario` | Painel principal do aluno |
| `/usuario/profile` | Perfil e dados pessoais |
| `/usuario/user/schedule` | Agenda de aulas |
| `/usuario/user/training` | Treinos atribuídos |

---

## 🏗️ Arquitetura e Design

### Padrão MVC

O projeto segue o padrão **Model-View-Controller** sem framework, proporcionando:

```
┌─────────────┐     ┌──────────────┐     ┌─────────────┐
│   Views     │────▶│  Controllers │────▶│   Models    │
│   (PHP)     │◀────│    (PHP)     │◀────│   (PDO)     │
└─────────────┘     └──────────────┘     └─────────────┘
                           │
                           ▼
                    ┌─────────────┐
                    │   MySQL     │
                    │  Database   │
                    └─────────────┘
```

### Roteamento

O sistema utiliza um **roteador simples** baseado em `switch-case` no `index.php`, mapeando URLs para arquivos PHP específicos.

### Namespaces

Os models utilizam namespaces organizados:
- `models\` - Models gerais (Usuario, Funcionario, Dashboard)
- `models\acesso\` - Controle de acesso (RFIDTags, RegistroEntrada)
- `models\agendamento\` - Aulas e participações
- `models\pagamento\` - Planos e pagamentos
- `models\sagef\` - Sistema de treinos (Exercicio, Treino, Pontuacao)

### Escolhas de Design

| Decisão | Justificativa |
|---------|---------------|
| **PHP Puro (sem framework)** | Controle total da arquitetura, aprendizado dos fundamentos do MVC, menor overhead |
| **PDO para MySQL** | Prepared statements para segurança contra SQL injection, portabilidade |
| **Bootstrap 5** | Responsividade nativa, componentes prontos, customização via SCSS |
| **Chart.js** | Gráficos leves e interativos, fácil integração com JavaScript |
| **SCSS** | Variáveis CSS, aninhamento, melhor organização de estilos |
| **Arduino + RFID** | Custo baixo, documentação abundante, comunidade ativa |

---

## 🛠️ Tecnologias Utilizadas

### Backend
- **PHP 8+** - Linguagem principal
- **MySQL** - Banco de dados relacional
- **PDO** - Abstração de banco de dados

### Frontend
- **HTML5/CSS3** - Estrutura e estilos
- **Bootstrap 5.3** - Framework CSS
- **SCSS/Sass** - Pré-processador CSS
- **JavaScript (ES6+)** - Interatividade
- **Chart.js 4.5** - Visualização de dados
- **Bootstrap Icons** - Iconografia

### IoT / Hardware
- **Arduino** - Microcontrolador
- **MFRC522** - Módulo leitor RFID
- **Python** - Script de leitura serial

### Ferramentas
- **Git** - Controle de versão
- **npm** - Gerenciamento de pacotes
- **Obsidian** - Documentação interna

---

## 📁 Estrutura do Projeto

```
techfit-system/
├── 📂 api/
│   └── dashApi.php           # API para dashboard
├── 📂 Assets/
│   ├── 📂 ino/
│   │   └── codigo_arduino.ino # Código do leitor RFID
│   ├── 📂 js/
│   │   └── dashboard.js       # Scripts do dashboard
│   ├── 📂 scss/
│   │   └── style.scss         # Estilos fonte
│   └── 📂 style/
│       └── style.css          # CSS compilado
├── 📂 config/
│   ├── Config.php             # Configurações gerais
│   └── Database.php           # Conexão PDO
├── 📂 controllers/
│   ├── UsuarioController.php
│   ├── 📂 acesso/
│   │   └── DashboardController.php
│   ├── 📂 agendamento/
│   │   ├── AulaController.php
│   │   └── CalendarioController.php
│   └── 📂 sagef/
│       ├── exercicioController.php
│       ├── feedbackController.php
│       └── treinoController.php
├── 📂 core/
│   └── Session.php            # Gerenciamento de sessão
├── 📂 Documentação/
│   ├── 📂 Database Planning/  # Modelos conceitual e lógico
│   ├── 📂 Prints/             # Screenshots do sistema
│   └── Documentação Técnica.docx
├── 📂 models/
│   ├── Dashboard.php          # Queries do dashboard
│   ├── Funcionario.php
│   ├── Usuario.php
│   ├── 📂 acesso/
│   │   ├── RFIDTags.php
│   │   └── RegistroEntrada.php
│   ├── 📂 agendamento/
│   │   ├── Aula.php
│   │   ├── Participacao.php
│   │   └── ParticipacoesAula.php
│   ├── 📂 pagamento/
│   │   ├── Pagamentos.php
│   │   └── Planos.php
│   └── 📂 sagef/
│       ├── Exercicio.php
│       ├── Pontuacao.php
│       ├── Treino.php
│       └── TreinoExercicios.php
├── 📂 public/
│   ├── home.php               # Página inicial
│   ├── login.php              # Autenticação
│   ├── academiasprox.php      # Lista de academias
│   ├── academias.json         # Dados das unidades
│   ├── 📂 images/             # Assets visuais
│   └── 📂 include/
│       ├── header.php
│       └── footer.php
├── 📂 TechFit/
│   ├── 📂 Classes/            # Documentação de classes
│   ├── 📂 Obsidian/           # Notas de desenvolvimento
│   └── 📂 Trello/             # Metodologias ágeis
├── 📂 views/
│   ├── 📂 agendamento/
│   │   └── aulas.php
│   ├── 📂 funcionario/
│   │   ├── main.php           # Dashboard
│   │   ├── RFID.php           # Monitor RFID
│   │   ├── register-classes.php
│   │   ├── register-exercises.php
│   │   ├── register-gym-students.php
│   │   ├── set-training.php
│   │   ├── salvar-treino.php
│   │   └── rfid_reader.py     # Script Python RFID
│   └── 📂 usuario/
│       ├── main.php
│       ├── profile.php
│       ├── user-schedule.php
│       └── user-training.php
├── index.php                  # Roteador principal
├── package.json
└── README.md
```

---


## 👥 Contribuidores

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/jggoncalez">
        <img src="https://github.com/jggoncalez.png" width="100px;" alt="João Gabriel"/>
        <br><sub><b>João Gabriel Gonçalez</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/Henrique-RMotta">
        <img src="https://github.com/Henrique-RMotta.png" width="100px;" alt="Henrique Motta"/>
        <br><sub><b>Henrique Rodrigues Motta</b></sub>
      </a>
    </td>
  </tr>
</table>

---

## 📄 Licença

Este projeto foi desenvolvido como trabalho acadêmico no **SENAI Limeira**.