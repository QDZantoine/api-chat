[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/antoinequendez/)


![Code Coverage](https://github.com/QDZantoine/api-chat/raw/main/.github/badges/coverage.svg)


# Api chat


## Description

This project involves the creation of a RESTful API using Symfony 7 to manage conversations between users and a chatbot. The API allows for CRUD (Create, Read, Update, Delete) operations on conversations and exchanged messages.

## Technologies

- **Backend**: Symfony 7
- **Database**: MySQL/PostgreSQL
- **API**: Implemented with API Platform, an extension of Symfony

## API Documentation

The API is documented and accessible via a Swagger interface, allowing developers to test and explore the various routes and available operations.

### API Endpoints

#### Conversation

- **GET** `/api/conversations`: Retrieves the collection of conversation resources.
- **POST** `/api/conversations`: Creates a conversation resource.
- **GET** `/api/conversations/{id}`: Retrieves a specific conversation resource.
- **PUT** `/api/conversations/{id}`: Replaces the conversation resource.
- **DELETE** `/api/conversations/{id}`: Deletes the conversation resource.
- **PATCH** `/api/conversations/{id}`: Partially updates the conversation resource.

#### Message

- **GET** `/api/messages`: Retrieves the collection of message resources.

### Swagger Interface

The API is documented and accessible via a Swagger interface, offering a user-friendly view to explore the endpoints, test various requests, and view responses. This greatly facilitates development and debugging of integrations.

![API Chat](public/images/api-chat.png)



## Requirements

- PHP 8.2
- PHP extensions curl,intl,mbstring,xml,zip,amqp,mysql,bcmath
- Composer
- MySQL
- Web server Apache 2.4

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
## Front-end API

You can use the project Front-chat:

[API-chat](https://github.com/QDZantoine/api-chat#)
