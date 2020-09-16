# CRUD API Rest & JWT

- Add Postman doc???

## Build with... (versions???)
- php (https://www.php.net/)
- mysql (https://www.mysql.com/)
- php-slim (http://www.slimframework.com/)
- php-slim-skeleton (https://github.com/slimphp/Slim-Skeleton)
- tuupola (JWT php slim) (https://github.com/tuupola/slim-jwt-auth)
- bootstrap (https://getbootstrap.com/)
- bootswatch (https://bootswatch.com/)
- ionicons (https://ionicons.com/)
- jquery (https://jquery.com/)


## Misc
API Rest
- GET
- POST
- PUT
- DELETE


## Install 
1. Clone the repository
- Configuracion de apache 
añadir el mod_rewrite en apache 
```sh
a2enmod rewrite // En ubuntu 
```
<Directory /var/www/html/>
        AllowOverride All
</Directory>


2. Install the database (database.sql)
3. Fill the user/pass fields for database in src/settings.php
4. Update dependencies
```sh
composer update
```
5. Start app 
```sh
composer start
```
6. Open browser and go to http://localhost:8080
7. Sign in with user@pass/pass
