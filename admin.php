<?php
//sets headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

//includes the config-file, which in turn loads all class-files
include('config/config.php');
include('functions/jwt.php');
include('functions/dataHandling.php');
//sets up a new instance of the Querys class
$query = new AdmContent();

$call = $_SERVER['REQUEST_METHOD'];
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

//all the calls for create, update and delete needs to go here
//everything also needs to be passwordprotected this was just copied from last project
//pls change as neeeded
if(checkJWT($authHeader)){
	//sets the $dataSet variable equal to the contents sent in the body
	$dataSet = json_decode(file_get_contents('php://input'));
	//swtich statement on the method used to call the endpoint
	switch($call){
		case 'POST':
			if($query->addThing($dataSet)){
				http_response_code(201);
				$result = array("message" => "Record created");
			} else{
				http_response_code(503);
				$result = array("message" => "Something went wrong");
			}
		break;

		case 'PUT':
			if($query->updThing($dataSet)){
				http_response_code(201);
				$result = array("message" => "Record updated");
			} else {
				http_response_code(500);
				$result = array("message" => "Something went wrong");
			}
		break;

		case 'DELETE':
			if($query->deleteThing($dataSet)){
				http_response_code(200);
				$result = array("message" => "Record deleted");
			} else{
				http_response_code(500);
				$result = array("message" => "Something went wrong");
			}
		break;
		default:
		$result = array("message" => "Unsupported method used");
	}
} else{
	$result = array ('message' => 'Bort med tassarna');
}

echo json_encode($result);