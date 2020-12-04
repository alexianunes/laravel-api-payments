## Sobre

-   Aplicação para realização de transações entre usuários.

## Requisito Geral

-   [Composer](https://getcomposer.org/download/)

## Orientações para rodar o projeto via Docker

-   1. Inicie os containers através do comando `docker-compose up -d`
-   2. Em seguida utilize `composer install` para que seja instalado todas as dependências do projeto.
-   3. Copie o arquivo `.env.example` e renomeie para `.env` feito isso é necessário configurar as seguintes variáveis:
        -   1. `APP_URL` = URL completa do projeto.
        -   2. `DB_HOST` = Nome do container do mysql no `docker-compose.yml`, nesse caso utlize: `db`
        -   3. `DB_DATABASE` = Nome do banco de dados no `docker-compose.yml`.
        -   4. `DB_USERNAME` = Por padrão utilize `root`.
        -   5. `DB_PASSWORD` = Senha inserida no `docker-compose.yml`.
-   4. Para finalizar, utilize o `php artisan migrate --seed` para executar todos os Migrations (criação de todas as tabelas) e popular as mesmas.

## Orientações para rodar o projeto em modo local

## Requisitos

-   PHP ^7.2
-   Laravel 8
-   MSYQL 5.7

-   1. Utilize `composer install` para que seja instalado todas as dependências do Projeto.
-   2. Em seguida copie o arquivo `.env.example` e renomeie para `.env` e configure os campos `APP_URL` com a URL completa do projeto, `DB_DATABASE` com o nome do banco de dados criado, `DB_USERNAME` e `DB_PASSWORD` com login e senha do banco de dados.
-   3. Para finalizar, utilize o `php artisan migrate --seed` para executar todos os Migrations (criação de todas as tabelas) e popular as mesmas.
