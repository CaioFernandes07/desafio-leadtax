# Desafio Técnico: Web Scraping

## Descrição do Desafio
O propósito deste projeto é criar uma aplicação Laravel que execute web scraping em um site de e-commerce, como o Mercado Livre. A aplicação coleta dados relevantes sobre os produtos e os armazena em um banco de dados, oferecendo uma interface web para consulta e visualização das informações extraídas.

## Funcionalidades
- **Web Scraping:** Coleta de dados de produtos como, titulo, preço, imagem.
- **Armazenamento em Banco de Dados:** Os dados coletados são armazenados em um banco de dados MySQL.
- **Interface Web:** Visualização dos produtos coletados em uma interface responsiva.


## Tecnologias Utilizadas
- **Laravel:** Framework PHP para desenvolvimento web.
- **MySQL:** Sistema de gerenciamento de banco de dados.
- **Guzzle:** Biblioteca PHP para realizar requisições HTTP.
- **Blade:** Motor de template do Laravel para renderização de views.
- **Tailwindcss:** Framework css usado para estilização.

## Requisitos
- PHP 8.0 ou superior
- Composer
- MySQL
- Laravel

## Instalação
Siga os passos abaixo para instalar e configurar a aplicação:

### Passo a passo

Clone Repositório

```sh
git clone https://github.com/CaioFernandes07/desafio-leadtax.git
```

```sh
cd app-laravel
```

Crie o Arquivo .env

```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env

```dosini
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

Executar o script

```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs 
```

Acesse o container app

```sh
docker-compose exec app bash
```

Instale as dependências do projeto

```sh
composer install
```
```sh
npm install
```

Gere a key do projeto Laravel

```sh
php artisan key:generate
```

Rode as migrations

```sh
php artisan migrate
```

Acesse o projeto
(http://localhost)
