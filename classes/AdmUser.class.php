<?php

class AdmUser extends Database{
	//handling login-things for the admin-user
	function loginAdmin($username, $password) {
		//fetches info for the chosen user
        $storedPass = $this->connect()->prepare("SELECT * FROM user where username=?");
        $storedPass->execute([$username]);
		$pass = $storedPass->fetch();
		//checks that the password sent matches the password stored in the database. 
		//the password stored in the database is of course hashed and salted
        if ($pass && password_verify($password, $pass['password'])) {
            return true;
        } else {
            return false;
        }
	}
}