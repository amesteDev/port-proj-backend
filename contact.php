<?php

//sets headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

$dataSet = json_decode(file_get_contents('php://input'));

function contactMail($name, $email, $title, $message){
	$strToMail = $message . "\n" . "Vänlingen " . $name;

    $headers = 'From: ' . $email . "\r\n" .
	'Reply-To: ' . $email . "\r\n";
	$headers .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
	$headers .= 'Content-Transfer-Encoding: base64';
    if(mail ("info@ameste.se", $title, $strToMail, $headers)){
        return True;
    } else {
        return False;
    }
}

if(contactMail($dataSet->name, $dataSet->mail, $dataSet->header, $dataSet->msg)){
	http_response_code(200);
	$result = array("message" => "Meddelande skickat!");
} else{
	$result = array("message" => "Något gick fel, försök igen senare eller skicka ett mail till info@ameste.se");
}

echo json_encode($result);