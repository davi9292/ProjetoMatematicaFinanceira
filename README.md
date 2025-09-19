# 🖱️ MOUSEFinanças - Plataforma de Educação Financeira

Uma plataforma completa de **educação financeira** desenvolvida pelos alunos  
**Davi de Assis Fabricio** e **Vinicius Queiroz**, utilizando tecnologias modernas.  

Inclui funcionalidades de **gerenciamento de despesas**, **simulações financeiras** e **conteúdo educativo interativo**.  

---

## 🚀 Tecnologias Utilizadas

<p align="center">
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" width="50" alt="HTML5"/>
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" width="50" alt="CSS3"/>
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" width="50" alt="JavaScript"/>
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" width="50" alt="PHP"/>
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" width="50" alt="MySQL"/>
  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" width="50" alt="Bootstrap"/>
</p>

---

## 💡 Funcionalidades

### 💰 Gerenciador de Despesas
- CRUD completo para despesas organizadas por categoria  
- Resumo mensal com gráficos interativos  
- Categorias: Moradia, Alimentação, Transporte, Lazer, Saúde, Educação, Vestuário, Outros  

### 🏦 Simulador de Financiamento
- Sistemas: SAC (Amortização Constante) e PRICE (Parcelas Fixas)  
- Tipos: Imobiliário, Veicular, Pessoal  
- Geração de tabela de amortização detalhada  

### 📈 Simulador de Investimento
- Cálculos com juros compostos  
- Suporte a valor inicial e aportes mensais  
- Projeção gráfica da evolução do investimento  

### 📚 Educação Financeira
- Tópicos educacionais com vídeos  
- Resumos práticos de conceitos financeiros  
- Interface moderna e responsiva  

---

## 📋 Pré-requisitos
- PHP 7.4 ou superior  
- MySQL 5.7 ou superior  
- Servidor Apache ou Nginx  
- PHPMyAdmin (opcional, recomendado)  

---

## 🔧 Instalação

### 1. Clone/Download do Projeto
```bash
# Exemplo de diretório:
# Linux/Mac: /var/www/html/mousefinancas
# Windows (XAMPP): C:\xampp\htdocs\mousefinancas
2. Configuração do Banco de Dados
Crie um banco chamado mousefinancas_db

Importe o arquivo /database/schema.sql

3. Configuração da Conexão
Edite /config/database.php:

php
Copiar código
private $db_name = 'mousefinancas_db';
private $username = 'seu_usuario';
private $password = 'sua_senha';
🌐 Acesso
Homepage: http://localhost/mousefinancas

PHPMyAdmin: Para gerenciar o banco

📊 Estrutura do Projeto
pgsql
Copiar código
mousefinancas-php/
├── api/
├── assets/
│   ├── css/
│   └── js/
├── config/
├── database/
├── includes/
├── index.php
└── README.md
📈 Próximas Melhorias
 Autenticação de usuários

 Exportação para PDF/Excel

 Dashboard avançado

 Modo escuro/claro


👨‍💻 Professores SENAI:
Este projeto foi pedido e orientado pelos professores:

Luis Felipe Cardozo

Lucas Machado

👨‍💻 Autores
Este projeto foi desenvolvido pelos alunos:

Davi de Assis Fabricio

Vinicius Queiroz


