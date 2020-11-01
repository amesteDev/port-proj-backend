<?php

use \Firebase\JWT\JWT;

require __DIR__ . '/vendor/autoload.php';

function createJWT(){
	//add your own secret_key, should probably be stored either in ENV-variables or some other file
	$secret_key = "?";
	$issuer_claim = "ameste.se";
	$issuedat_claim = time(); // issued at
	$notbefore_claim = $issuedat_claim - 10; // -10 to ensure that the token is usable at the time it is issued
	$expire_claim = $issuedat_claim + 1800; // expires 1800 (30 min) seconds after it was issued.
	//sets up an array of the values
	$token = array(
		"iss" => $issuer_claim,
		"iat" => $issuedat_claim,
		"exp" => $expire_claim,
		"nbf" => $notbefore_claim,
		"username" => 'ameste',
	);
	//creates the JWT
	$jwt = JWT::encode($token, $secret_key);
	//returns the JWT and some other things
	return $result = array(
		'jwt' => $jwt,
		"message" => "Logged in!",
		"expireAt" => $expire_claim
	);
}

function checkJWT($authHeader){
	//if there is an header present
	if($authHeader){
		$jwt = null;
		$arr = explode(" ", $authHeader);
			//add your own secret_key, should probably be stored either in ENV-variables or some other file
			//this needs to match the on in createJWT
	$secret_key = "?";
		$jwt = $arr[1];
		//if there is an jwt (this check might be reduntant)
		if($jwt){
			try {
				//decode the JWT and check if it is valid
				$decoded = JWT::decode($jwt, $secret_key, array('HS256'));
				return true;
			}catch (Exception $e){
				return false;
			}

		}
	}
}




