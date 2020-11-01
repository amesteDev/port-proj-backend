<?php

class Database{

//this uses constants that are defined in a file called dbconf.php
//set dbaname to match you DB and $login is usename $password is password for the dabase
	private $dsn = "mysql:host=localhost;dbname=portfolio";
    private $login = "placeholder";
    private $password = "password";
    //sets up the connection to the database
    protected function connect(){
        try {
            $pdo = new PDO($this->dsn, $this->login, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $pdo;
        } catch (Exception $e) {
            throw $e;
            throw new PDOException("Could not connect to database, hiding details.");
        }
    }
}