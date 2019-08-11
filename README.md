# Readme

## CRUD API Rest & JWT

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



## Desarrollo 

- Instalar slim-skeleton
```sh
php composer.phar create-project slim/slim-skeleton [my-app-name]
```

## Database
```sql
CREATE DATABASE IF NOT EXISTS api_slim;
USE api_slim;

DROP TABLE users;
CREATE TABLE IF NOT EXISTS users(
  id int(10) UNSIGNED NOT NULL,
  first_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  last_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  email varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  password varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY users_email_unique (email);

ALTER TABLE users
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

-- pass
INSERT INTO users (first_name, last_name, email, password) VALUES ('user', 'pass', 'user@pass', '$2y$10$ITIN3SaPqeZ4IYYg3YpSweGU83ObnLkqeG1FkdWjzb5eeOZd5S6zC');
```



# Slim Framework 3 Skeleton Application

Use this skeleton application to quickly setup and start working on a new Slim Framework 3 application. This application uses the latest Slim 3 with the PHP-View template renderer. It also uses the Monolog logger.

This skeleton application was built for Composer. This makes setting up a new Slim Framework application quick and easy.

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can run these commands 

	cd [my-app-name]
	php composer.phar start

Run this command in the application directory to run the test suite

	php composer.phar test

That's it! Now go build something cool.
