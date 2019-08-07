<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;


/*
	TRY CATCH en las consultas 
	https://cursos.mejorcodigo.net/article/crear-rest-api-con-slim-php-y-mysql-29
*/

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->get('/test/test', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/test' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
	});
	
	$app->get('/panel',function(Request $request, Response $response, array $args) use ($container){
		return $container->get('renderer')->render($response, 'panel.phtml', $args);
	});

    $app->post('/auth/login', function (Request $request, Response $response, array $args) {
	 
	    $input = $request->getParsedBody();
	    $sql = "SELECT * FROM users WHERE email= :email";
	    $sth = $this->db->prepare($sql);
	    $sth->bindParam("email", $input['email']);
	    $sth->execute();
	    $user = $sth->fetchObject();
	 
	    // verify email address.
	    if(!$user) {
	        return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
	    }
	 
	    // verify password.
	    if (!password_verify($input['password'],$user->password)) {
	        return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
	    }
	 
	    $settings = $this->get('settings'); // get settings array.
	    
	    $token = JWT::encode(['id' => $user->id, 'email' => $user->email], $settings['jwt']['secret'], "HS256");
	 
	    return $this->response->withJson(['token' => $token]);
	 
	});



	$app->group('/api', function(\Slim\App $app) {
 
		
		$app->post('/user/add',function(Request $request, Response $response, array $args) {
			
			$input = $request->getParsedBody();
			
			$sql = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES (:fist_name, :last_name, :email, :password, :created_at, :updated_at)";
			$sth = $this->db->prepare($sql);
			$sth->bindParam("fist_name", $input['firstname']);
			$sth->bindParam("last_name", $input['lastname']);
			$sth->bindParam("email", $input['email']);
			$sth->bindParam("password", $input['password']);
			$sth->bindParam("created_at", date("Y-m-d H:i:s"));
			$sth->bindParam("updated_at", date("Y-m-d H:i:s"));
			$sth->execute();

			return $this->response->withJson($input);
		});

		$app->delete('/user/delete/{id}',function(Request $request, Response $response, array $args) {

			$id = $request->getAttribute('id');
			
			$sql = "DELETE FROM users WHERE id = :id_user";
			$sth = $this->db->prepare($sql);
			$sth->bindParam("id_user", $id);
			$sth->execute();

			return $this->response->withJson(['out' => 'Eliminado.']);
		});

		
		$app->get('/user',function(Request $request, Response $response, array $args) {
	        print_r($request->getAttribute('decoded_token_data'));
	 
	        /*output 
	        stdClass Object
	            (
	                [id] => 2
	                [email] => arjunphp@gmail.com
	            )
	                    
	        */
		});
		
		$app->get('/users',function(Request $request, Response $response, array $args) {
			// print_r($request->getAttribute('decoded_token_data'));
			
			// $input = $request->getParsedBody();
			$sql = "SELECT * FROM users";
			$sth = $this->db->prepare($sql);
			$sth->execute();
			$users = $sth->fetchAll();

			// print(json_encode($users));
			return $this->response->withJson($users);
	    });
	   
	});



};
