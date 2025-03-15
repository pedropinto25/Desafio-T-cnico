# Projeto de Entrevista - Desafio Técnico

## Descrição

Este projeto é uma aplicação web desenvolvida em PHP para gerenciar clientes e usuários. A aplicação inclui funcionalidades como login, listagem de clientes, edição de clientes, entre outras.

## Estrutura do Projeto
Desafio-T-cnico/
└── project/
    ├── app/
    │   ├── controllers/
    │       └── UserController.php
    │       └── ClientController.php
    │   ├── models/
    │       └── UserModel.php
    │   ├── views/
    │       └── login.php
    │       └── clientList.php
    ├── config/
    │   └── database.php
    ├── public/
    │   └── index.php
    ├── vendor/
    └── .env

## Requisitos

- PHP 7.4 ou superior
- Composer
- Servidor web (Apache, Nginx, etc.)
- Banco de dados MySQL

## Instalação

1. Clone o repositório para o seu ambiente local:

   git clone https://github.com/seu-usuario/seu-repositorio.git
   
2. Navegue até ao diretório do projeto:
cd -repositorio

3.Instale as dependências do Composer:
composer install

4.Crie um arquivo .env na raiz do projeto e configure as variáveis de ambiente:

DB_HOST=#####
DB_NAME=#####
DB_USER=#####
DB_PASS=#####

5.Execute o arquivo SQL fornecido.

6.Configure o servidor web para apontar para o diretório public do projeto.

Uso
1. Aceda a aplicação no navegador através do URL configurado no servidor web.

2. Faça login com as credenciais fornecidas.

3.Navegue pelas funcionalidades da aplicação, como listagem de clientes, edição de clientes, etc.

Decisões Técnicas
1. Estrutura MVC: A aplicação segue o padrão de arquitetura MVC (Model-View-Controller) para separar a lógica de negócios, a interface do utilizador e o controlo de fluxo.

2. Dotenv: A biblioteca vlucas/phpdotenv é utilizada para gerir variáveis de ambiente de forma segura.

3. Composer: O Composer é utilizado para gerir as dependências do projeto.

### Conclusão

Este README fornece uma visão geral abrangente do projeto, incluindo instruções de instalação, configuração, uso e decisões técnicas. 
