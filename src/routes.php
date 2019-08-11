<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

return function (App $app) {

    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {

		return $container->get('renderer')->render($response, 'index.phtml', $args);
		
    });
	
	$app->get('/panel',function(Request $request, Response $response, array $args) use ($container){
		
		return $container->get('renderer')->render($response, 'panel.phtml', $args);
		
	});

    $app->post('/auth/login', function (Request $request, Response $response, array $args) use ($container){

		try {
			$input = $request->getParsedBody();
			$container->get('logger')->info("Attempt to identify (".$input['email'].")");
			$sql = "SELECT * FROM users WHERE email= :email";
			$sth = $this->db->prepare($sql);
			$sth->bindParam("email", $input['email']);
			$sth->execute();
			$user = $sth->fetchObject();
		} catch(PDOException $e) {
			$container->get('logger')->info("Error: ".$e->getMessage().")");
			return $this->response->withJson(['error' => true, 'message' => $e->getMessage()]);
		}
	 
	    if(!$user) {
			$container->get('logger')->info("Error: These credentials do not match our records.)");
	        return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
	    }
	 
	    if (!password_verify($input['password'],$user->password)) {
			$container->get('logger')->info("Error: These credentials do not match our records.)");
	        return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
	    }
	 
	    $settings = $this->get('settings');
	    $token = JWT::encode(['id' => $user->id, 'email' => $user->email], $settings['jwt']['secret'], $settings['jwt']['algorithm']);
	 
		$container->get('logger')->info("/auth/login Login OK.");
	    return $this->response->withJson(['token' => $token]);
	 
	});

	$app->group('/api', function(\Slim\App $app) use ($container){
		
		$app->post('/user/add',function(Request $request, Response $response, array $args) use ($container){
			
			try {
				$input = $request->getParsedBody();
				$sql = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES (:fist_name, :last_name, :email, :password, :created_at, :updated_at)";
				$sth = $this->db->prepare($sql);
				$pass = password_hash($input['password'], PASSWORD_BCRYPT);
				$now = date("Y-m-d H:i:s");
				$sth->bindParam("fist_name", $input['firstname']);
				$sth->bindParam("last_name", $input['lastname']);
				$sth->bindParam("email", $input['email']);
				$sth->bindParam("password", $pass);
				$sth->bindParam("created_at", $now);
				$sth->bindParam("updated_at", $now);
				$sth->execute();
			} catch(PDOException $e) {
				$container->get('logger')->info("/api/user/add Error: ".$e->getMessage().")");
				return $this->response->withJson(['error' => true, 'message' => $e->getMessage()]);
			}

			$container->get('logger')->info("/api/user/add '".$input['email']."' User: ".$request->getAttribute('decoded_token_data')['email']);
			return $this->response->withJson($input);
		});

		$app->delete('/user/delete/{id}',function(Request $request, Response $response, array $args) use ($container){

			try{
				$id = $request->getAttribute('id');
				$sql = "DELETE FROM users WHERE id = :id";
				$sth = $this->db->prepare($sql);
				$sth->bindParam("id", $id);
				$sth->execute();
			} catch(PDOException $e) {
				$container->get('logger')->info("/api/user/delete Error: ".$e->getMessage().")");
				return $this->response->withJson(['error' => true, 'message' => $e->getMessage()]);
			}

			$container->get('logger')->info("/api/user/delete '".$id."' User: ".$request->getAttribute('decoded_token_data')['email']);
			return $this->response->withJson(['out' => 'Deleted.']);
		});

		$app->put('/user/update',function(Request $request, Response $response, array $args) use ($container){
			
			try{	
				$input = $request->getParsedBody();
				if($input['sw_password']){
					$sql = "UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, password=:password, updated_at=:updated_at  WHERE id=:id";
					$sth = $this->db->prepare($sql);
					$pass = password_hash($input['password'], PASSWORD_BCRYPT);
					$sth->bindParam("password", $pass);
				}else{
					$sql = "UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, updated_at=:updated_at  WHERE id=:id";
					$sth = $this->db->prepare($sql);
				}
				$now = date("Y-m-d H:i:s");
				$sth->bindParam("id", $input['id']);
				$sth->bindParam("first_name", $input['firstname']);
				$sth->bindParam("last_name", $input['lastname']);
				$sth->bindParam("email", $input['email']);
				$sth->bindParam("updated_at", $now);
				$sth->execute();
			} catch(PDOException $e) {
				$container->get('logger')->info("/api/user/update Error: ".$e->getMessage().")");
				return $this->response->withJson(['error' => true, 'message' => $e->getMessage()]);
			}

			$container->get('logger')->info("/api/user/update '".$input['email']."' User: ".$request->getAttribute('decoded_token_data')['email']);
			return $this->response->withJson(['out' => 'Updated.']);
			
		});
		
		$app->get('/user',function(Request $request, Response $response, array $args) use ($container){

	        print_r($request->getAttribute('decoded_token_data'));
	        /*output 
	        stdClass Object(
	                [id] => 2
	                [email] => arjunphp@gmail.com
	            )       
	        */
		});
		
		$app->get('/users',function(Request $request, Response $response, array $args) use ($container){
			
			try{
				$sql = "SELECT * FROM users";
				$sth = $this->db->prepare($sql);
				$sth->execute();
				$users = $sth->fetchAll();
			} catch(PDOException $e) {
				$container->get('logger')->info("/api/users Error: ".$e->getMessage().")");
				return $this->response->withJson(['error' => true, 'message' => $e->getMessage()]);
			}

			$container->get('logger')->info("/api/users User: ".$request->getAttribute('decoded_token_data')['email']);
			return $this->response->withJson(['user' => $request->getAttribute('decoded_token_data')['email'],
				'users' => $users]);

	    });
	   
	});



};
