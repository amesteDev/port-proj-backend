<?php

class Content extends Database{

	//make a call to this method with what table to get data from

	function getThing($thingToGet){
		//change this array to the actual tables in the DB that will be accesible with this method
		$allowedTables = array('job', 'projs', 'edu', 'about');
		//check that the table specified in the request is in $allowedTables and then fetches
		//and returns the data, if any, from that table
		if(in_array($thingToGet, $allowedTables)){
		$sql = "SELECT * FROM $thingToGet";
		$stmnt = $this->connect()->prepare($sql);
		$stmnt->execute();
		$response = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if(count($response) > 0){
			return $response;
		}
	} else{
		return false;
	}
	}
}