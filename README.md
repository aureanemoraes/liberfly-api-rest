# Teste técnico - Liberfly
API REST desenvolvido para teste técnico da empresa Liberfly.

## Executando o projeto
### Clonando o projeto
`git clone git@github.com:aureanemoraes/liberfly-api-rest.git`

`cd liberfly-api-rest`

### Via docker compose
`docker compose up` 

### Localmente

Configure o .env com os dados do seu DB

`cp .env.example .env`

Instale as dependencias 

`composer install`

Gere o JWT Secret

`php artisan jwt:secret`

Rode as migrations e seeders

`php artisan migrate --seed`

Gere a chave da aplicação

`php artisan key:generate`

Execute o server

`php artisan serve`

## Para acessar a documentação - SWAGGER
`http://localhost:8000/api/documentation`

