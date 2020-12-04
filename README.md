## Sobre

-   Aplicação para realização de transações entre usuários.

## Requisitos

-   PHP 7.2+
-   Laravel 8+
-   MSYQL 5.7+
-   Composer

## Orientações para rodar o projeto via Docker

-   1. Inicie os containers através do comando "docker-compose up -d"
-   2. Renomeie o arquivo ".env.example" para ".env" e configure os campos APP_URL com a URL completa do projeto.
-   3. Ainda no .env altere os seguintes itens de acordo com as configurações inseridas no "docker-compose.yml": DB_DATABASE com o nome do banco de dados, DB_USERNAME e DB_PASSWORD com login e senha do banco de dados.
-   4. Em seguida utilize "composer install" para que seja instalado todas as dependências do Projeto.
-   5. Para finalizar, utilize o "php artisan migrate --seed" para executar todos os Migrations (criação de todas as tabelas) e popular as mesmas.

## Orientações para rodar o projeto em modo local

-   1. Renomeie o arquivo ".env.example" para ".env" e configure os campos APP_URL com a URL completa do projeto, DB_DATABASE com o nome do banco de dados criado, DB_USERNAME e DB_PASSWORD com login e senha do banco de dados.
-   2. Em seguida utilize "composer install" para que seja instalado todas as dependências do Projeto.
-   3. Para finalizar, utilize o "php artisan migrate --seed" para executar todos os Migrations (criação de todas as tabelas) e popular as mesmas.
