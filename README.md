[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/antoinequendez/)

# Api chat

![Language](https://img.shields.io/badge/language-EN-green)

![Langue](https://img.shields.io/badge/langue-FR-blue)


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

 Setup the .env.local file to access to the database:
```bash
 touch .env.local
 ```
 To create a symbolic link with .env.local and .env.local.test
 ```bash
 ln -s .env.local .env.test.local
 ```

put the configuration for the DB into this files:

```
APP_ENV=dev
DATABASE_URL=mysqli://apichatuser:'ChangeMe'@127.0.0.1:3306/api-chat?serverVersion=11.1.2-MariaDB&charset=utf8mb4
```

```bash
nano .env.local # setup database url
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

Open the app in your Browser http://api-chat.localhost/
