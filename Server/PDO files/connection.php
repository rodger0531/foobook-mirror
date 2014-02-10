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

/*
* @author Filip, Rodger, Tharman and Abdi.
*
*
* @class : This is the "user" class this class is responsible for 
create, read, update and delete (CRUD) funtionalities with database using PHP 
Data Object ( PDO ) with Prepared Statement.
*/
 
class CRUD extends DB
 {

	private $pdo;
	public  $result;
	 
	public function __construct(){
		
	}
/*
* @function: This is the the function which is responsible for reading a single entry from a table.
*
* @arguments: $id
* @return : single stdClass Object array.
*/
 
	public function readOne($query){
	 
	try {
	$this->pdo = $this->connectMySql();
	 
	$stmt = $this->pdo->prepare($query);
	 
		 
	if(!$stmt->execute()){
	echo "Execute failed: (" .$stmt->errno . ")" . $stmt -> errno;
	return false;
	}
	 
	$nart = $stmt->rowCount();
	 
	if ($nart == 0) {
	echo "Query failed: (" .$stmt->errno . ")" . $stmt -> errno;
	return "No Entry found in table";
	}
	 
	$this->result = $stmt->fetch(PDO::FETCH_OBJ);
	 
	$this->pdo = null;
	 
	return $this->result;
	 
	} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	 
	}
	return NULL;
	}
} 

?>