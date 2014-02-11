<?php
/*
* @author Filip, Rodger, Tharman and Abdi.
*
*
* @class : This is the Abstract DB class, the purpose of this class is to resolve the connection to the database.
*/

abstract class DB{
 
/*
*@function: This is the the function which is responsible for connecting
 with database.
*
* @arguments: null
* @return : connection link.
*/

public function connectMySql(){
	
	require_once __DIR__ . '/db_config.php';

	$dsn = DSN;
	$user = DB_USER;
	$password = DB_PASSWORD;
	
	try{
	$pdoLink = new PDO($dsn, $user, $password);
	}catch(PDOException $e){
	echo "Connection Failed :: ".$e->getMessage();
	return false;
	}
	return $pdoLink;
	}
 
}

?>