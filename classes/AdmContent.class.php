<?php

class AdmContent extends Database{
	//change this array to control what tables in the DB should be accesible by this class
	private $allowedTables = array('job', 'projs', 'edu', 'about');
	//setting up a bunch of variables used by the various methods
	private $columns = "";
	private $values = "";
	private $args = array();
	private $columnsToUpdate = "";
	private $update = false;
	private $id = "";

	//check if the amount of 
	private function tableLength($length, $tableToAdd){
		//this fetches the amount of columns in a table
		$stmnt = $this->connect()->prepare("SELECT count(*) FROM information_schema.columns WHERE table_schema = 'ameste_portfolio' AND table_name = ?;");
		$stmnt->execute([$tableToAdd]);
		//checks if the number of columns i equal to the $length - 1
		if($stmnt->fetch(PDO::FETCH_COLUMN) == $length - 1){
			return true;
		} else{
			return false;
		}
	}

	private function setData($dataSet) {
		//slice to remove the first index of the array, since that is only the table-name and is not needed to construct 
		//column-data before sending it to the database
		if($this->update == false){
			foreach (array_slice(get_object_vars($dataSet),1) as $key => $val){
				//sets the $this->columns equal to the columns that are gonna be added
				//aswell as the $this->values to the values that are gonna be added
				$this->columns .= $key . ', ';
				$this->values .= '"' . $val . '"' . ', ';
			}
			//remove the last , of the strings
			$this->columns = substr($this->columns, 0, -2);
			$this->values = substr($this->values, 0, -2);
		} else {
			foreach (array_slice(get_object_vars($dataSet),1) as $key => $val){
				//here instead an array is created of the values that are gonna be updated
			array_push($this->args, $val);
			$this->values .= $val . ', ';
			//if the key is != id add the key and =? to the columnstoupdate. this sets up the columnstoupdate like this example:
			//title=?,year=?,description=?
			//this is then used in the call to the database
			if($key != 'id'){
				$this->columnsToUpdate .= $key . '=?,';
			} else {
				$this->id = $key;
			}
		}
			$this->columnsToUpdate = substr($this->columnsToUpdate, 0, -1);
			$code = array_shift($this->args);
			array_push($this->args, $code);
		}
	}
//this is to add something to the database
	function addThing($dataSet){
		//check that the table is in allowedtable
		if(in_array($dataSet->table, $this->allowedTables)){
			//check that the right amount of data is sent
			if($this->tableLength(countData($dataSet), $dataSet->table)){
				//add to database
				$this->setData($dataSet);
				$sql =  "INSERT INTO $dataSet->table ($this->columns) VALUES ($this->values);";
				$stmnt = $this->connect()->prepare($sql);
				if($stmnt->execute()){
					return true;
				}
			}
		}
	}
//delete something
	function deleteThing($dataSet){
		//check that the table is in allowedtable
		if(in_array($dataSet->table, $this->allowedTables)){
			//delete
			$sql = "DELETE FROM $dataSet->table WHERE id=?";
			$stmnt = $this->connect()->prepare($sql);
			if($stmnt->execute([$dataSet->id])){
				return true;
			}
		}
	}
//update something
	function updThing($dataSet){
		//check that the table is in allowedtable
		if(in_array($dataSet->table, $this->allowedTables)){
			//check that the right amount of data is sent
			if($this->tableLength(countData($dataSet), $dataSet->table)){
				//update
				$this->update = true;
				$this->setData($dataSet);		
				$sql = "UPDATE $dataSet->table SET $this->columnsToUpdate WHERE $this->id=?";
				$stmnt = $this->connect()->prepare($sql);
				$stmnt->execute($this->args);
			}
			return true;
		}
	}
}