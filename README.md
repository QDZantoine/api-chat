[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/antoinequendez/)

# Api chat

![Code Coverage](https://github.com/QDZantoine/api-chat/raw/main/.github/badges/coverage.svg)

 ## Projet d'API de Conversations entre Utilisateurs et Chatbot

## Description

Ce projet consiste en la création d'une API RESTful avec Symfony 7 pour gérer les conversations entre utilisateurs et un chatbot. L'API permet de réaliser des opérations CRUD (Create, Read, Update, Delete) sur les conversations et les messages échangés.

## Technologies

- **Backend** : Symfony 7
- **Base de Données** : MySQL/PostgreSQL
- **API** : Implémentée avec API Platform, une extension de Symfony

## Documentation de l'API

L'API est documentée et accessible via une interface Swagger, permettant aux développeurs de tester et d'explorer les différentes routes et opérations disponibles.

### Endpoints de l'API

#### Conversation

- **GET** `/api/conversations` : Récupère la collection de ressources de conversation.
- **POST** `/api/conversations` : Crée une ressource de conversation.
- **GET** `/api/conversations/{id}` : Récupère une ressource de conversation spécifique.
- **PUT** `/api/conversations/{id}` : Remplace la ressource de conversation.
- **DELETE** `/api/conversations/{id}` : Supprime la ressource de conversation.
- **PATCH** `/api/conversations/{id}` : Met à jour partiellement la ressource de conversation.

#### Message

- **GET** `/api/messages` : Récupère la collection de ressources de message.

### Interface Swagger

L'API est documentée et accessible via une interface Swagger, offrant une vue conviviale pour explorer les endpoints, tester les différentes requêtes et consulter les réponses. Cela facilite grandement le développement et le débogage des intégrations.

![API Chat](public/images/api-chat.png)


## Requirements

- PHP 8.2
- PHP extensions curl,intl,mbstring,xml,zip,amqp,mysql,bcmath
- Composer
- MySQL
- Web server Apache 2.4

## Additional Documentation


## Install application

Clone [api-chat repository](https://github.com/QDZantoine/api-chat)

```bash
git clone git@github.com:QDZantoine/api-chat.git
```
## Add project host
```bash
sudo nano /etc/hosts
  127.0.0.1 api-chat.localhost
```
## Add apache config
```bash
sudo nano /etc/apache2/sites-available/api-chat.conf
```

```nano
<VirtualHost *:80>

    # http://api-chat.localhost/
    ServerName api-chat.localhost

    LogLevel warn
    ErrorLog ${APACHE_LOG_DIR}/error_api-chat.log
    CustomLog ${APACHE_LOG_DIR}/access_api-chat.log combined

    <FilesMatch \.php$>
        SetHandler proxy:unix:/var/run/php/php8.3-fpm.sock|fcgi://dummy
    </FilesMatch>
    # Security
    ServerSignature Off

    DocumentRoot /opt/git/qdz-antoine/api-chat/public/
    <Directory /opt/git/qdz-antoine/api-chat/public/>
        Require all granted
        AllowOverride None
        FallbackResource /index.php
    </Directory>
</VirtualHost>
```

## Enable the new site 
```bash
sudo a2ensite api-chat
sudo apache2ctl restart
```
## Setup the DB

```sql
create database `api-chat` CHARACTER SET utf8 COLLATE utf8_unicode_ci;
```
generate a password for the user of the database that you gonna create:
```bash
echo "$(head /dev/urandom | tr -dc A-Za-z0-9 | head -c 13)"
```
use the password to define a DB user:

```sql
create user `apichatuser`@`localhost` identified by 'ChangeMe';
grant all privileges on `api-chat`.* to `apichatuser`@`localhost` with grant option;
FLUSH PRIVILEGES;
quit;
```	


put the configuration for the DB into this files:

```
APP_ENV=dev
DATABASE_URL=mysqli://apichatuser:'ChangeMe'@127.0.0.1:3306/api-chat?serverVersion=11.1.2-MariaDB&charset=utf8mb4
```

```bash
nano .env.local # setup database url
```
To create a symbolic link with .env.local and .env.local.test
```bash
ln -s .env.local .env.test.local
```
## Create the database
```
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
```

Run fixtures  (use this command to get the starting DB whitout the data been uploaded)
```bash
composer fixtures
```

Open the app in your Browser http://api-chat.localhost/api

### Command to test the api with curl:

```bash
curl -X 'GET' 'http://api-chat.localhost/api/conversations?page=1' -H 'accept: application/ld+json'
```