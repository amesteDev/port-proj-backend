<?php
//sets headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-with');

//includes the config-file, which in turn loads all class-files
include('config/config.php');
include('functions/jwt.php');
include('functions/dataHandling.php');
//sets up a new instance of the Querys class
$query = new AdmContent();

$call = $_SERVER['REQUEST_METHOD'];
$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

if(checkJWT($authHeader)){
	//code for handling the file and then return the uri of it
	if(count($_FILES) > 0) {
		$file = $_FILES['img'];
		$target_dir = "../img/";
		$store_dir = "/img/";
		$target_file = $target_dir . basename($file["name"]);
		$uploadOk = true;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        //check if the file is an actual image
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            $uploadOk = true;
        } else {
            $uploadOk = false;
            exit();
        }
        // Check file size
        if ($file["size"] > 500000) {
            $uploadOk = false;
        }

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		$uploadOk = false;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == false) {
		$result = array("msg" => "Error with fileupload");

	// if everything is ok, try to upload file
	} else{
		$newfilename = round(microtime(true)) . '.' . $imageFileType;
		if (move_uploaded_file($file["tmp_name"], $target_dir . $newfilename)) {
			$result = array("status" => $uploadOk, "path" => $target_dir . $newfilename);
		} else {
			$result = array("status" => $uploadOk, "msg" => "Something broke";
		}
	}

	} else {
		$result = array("msg" => "You need to seend a file");
	}
} else{
	$result = array ('message' => 'Bort med tassarna');
}

echo json_encode($result);