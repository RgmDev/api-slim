# Readme

## Introducción

CRUD API REST con integración de validación de usuarios por token (JWT)

## Cosas
- Logs 
- Despliegue & instalacion
- Token Expired 



## Dependencias
- guide (https://arjunphp.com/secure-web-services-using-jwt-slim3-framework/)
- php (https://www.php.net/)
- mysql (https://www.mysql.com/)
- php-slim (http://www.slimframework.com/)
- php-slim-skeleton (https://github.com/slimphp/Slim-Skeleton)
- tuupola (JWT php slim) (https://github.com/tuupola/slim-jwt-auth)
- bootstrap (https://getbootstrap.com/)
- jquery (https://jquery.com/)
- ionicons (https://ionicons.com/)

## Entorno 
Host: Ubuntu 18
Servidor Apache

## Desarrollo 

- Instalar slim-skeleton
```sh
php composer.phar create-project slim/slim-skeleton [my-app-name]
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
