<?php
//sets headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

//includes the config-file, which in turn loads all class-files
include('config/config.php');

//sets up a new instance of the Querys class
$query = new Content();
$call = $_SERVER['REQUEST_METHOD'];
//if the request method is == get
if($call == 'GET'){
	//and there is a table-variable set
	if(isset($_GET['table'])){
		//run the method getThing with the table-variable and if it returns data send that data
		if($result = $query->getThing($_GET['table'])){
			http_response_code(200);
			//else say that nothing was found
		} else{
			http_response_code(404);
			$result = array("message" => "Nothing found in db");
		}
		//if the value of the table variable was not found in the allowed tables send acces denied
	} else { $result = array("message" => "Access denied!"); }
//if some other method than GET was used, tell them aobut it!
} else { $result = array("message" => "Only allowed to get from this URL"); }

echo json_encode($result);