### Projeto API REST com Symfony e Front-End com Vue.js

## Descrição
Este projeto consiste em uma API REST desenvolvida com PHP 8.1, Symfony 6.4 e PostgreSQL no back-end, e um front-end desenvolvido com Vue.js 3 e Tailwind CSS. O projeto é configurado para ser executado com Docker, facilitando o processo de desenvolvimento e implantação.

## Requisitos
Antes de começar, certifique-se de ter o Docker e o Docker Compose instalados na sua máquina.
Caso não utilize docker pular etapas onde são executado comandos "docker"

## Estrutura do Projeto
backend/ - Contém a API REST desenvolvida com Symfony.
frontend/ - Contém a aplicação Vue.js com Tailwind CSS.

## Executar o Projeto com Docker
# Passos

- Clone o repositório
- git clone https://gitlab.com/psempionato/vox-test.git
- cd <Repositorio>
- Na raiz do projeto, execute o seguinte comando para construir e iniciar os containers: docker-compose up -d --build

# backend
- Acesse o container: docker exec -it <nome-container-backend> bash
- cd api
- composer install
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate
- symfony server:start

A API estará disponível em http://localhost:8000.

# frontend
- Acesse o container: docker exec -it <nome-container-front> bash
- cd vue-app
- npm install
- npm run serve

O front-end estará disponível em http://localhost:8080.




