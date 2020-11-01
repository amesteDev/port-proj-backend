<?php
//sets headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

//includes the config-file, which in turn loads all class-files
include('config/config.php');
include('functions/jwt.php');

//sets up a new instance of the Querys class
$query = new AdmUser();
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
	//sets the $dataSet variable equal to the contents sent in the body
	$dataSet = json_decode(file_get_contents('php://input'));
	//check the value of the meth-variable in the call and runs a switch statement
	switch($dataSet->meth){
		//if it is LOGIN, try to login
		case 'LOGIN':
			if($query->loginAdmin($dataSet->username, $dataSet->password)){
				http_response_code(200);
				$result = createJWT();
			} else{
				http_response_code(401);
				$result = array("message" => "fail");
			}
	
		break;
		//if it is CHECK, check the authorization header
		case 'CHECK':
			$result = 'kram';
			if(checkJWT($authHeader)){
				http_response_code(200);
				$result = array("message" => "ok");

			} else {
				http_response_code(401);
				$result = array("message" => "goodbye");
			}
		break;
		default:
		http_response_code(401);
		$result = array("message" => "Bort med tassarna!");
	}

echo json_encode($result);