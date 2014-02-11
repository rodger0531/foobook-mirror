<?php
 
/*
 * @author Filip, Rodger, Tharman and Abdi.
 *
 * @class : This is the Abstract DB class, the purpose of this class is to resolve the connection to the database.
 */
abstract class DB{
 
	/*
	 * @function: This is the function which is responsible for connecting with database.
	 *  
	 * @arguments: null
	 * @return : connection link.
	 */
	public function connectMySql(){
	
		require_once __DIR__ . '/db_config.php';


		$dsn = DSN;
		$user = DB_USER;
		$password = DB_PASSWORD;
		try {
			$pdoLink = new PDO($dsn, $user, $password);
		}
		catch(PDOException $e) {
			echo "Connection Failed :: ".$e->getMessage();
			return false;
		}
		return $pdoLink;
	}

}

/*
 * @author Filip, Rodger, Tharman and Abdi.
 *
 * @class : This is the "CRUD" class that is responsible for create, read, update and delete (CRUD)
 * funtionalities with database using PHP Data Object ( PDO ) with Prepared Statement.
 */
class CRUD extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	 * @function: This is the the function which is responsible for inderting a single entry into a table.
	 *
	 * @arguments: $query
	 */
	public function create($params) {
		try {
			$this->pdo = $this->connectMySql();

			$query = "INSERT INTO user SET
				first_name = :first_name,
				last_name = :last_name,
				email = :email,
				password = :password,
				date_of_birth = :date_of_birth,
				gender = :gender";

			$stmt = $this->pdo->prepare($query);

			$stmt->bindParam(':first_name', $params['first_name'], PDO::PARAM_STR); // PDO::PARAM_STR is used for treating $params['title_en'] as String
			$stmt->bindParam(':last_name', $params['last_name'], PDO::PARAM_STR);
			$stmt->bindParam(':email' ,$params['email'], PDO::PARAM_STR);
			$stmt->bindParam(':password', $params['password'], PDO::PARAM_STR);
			$stmt->bindParam(':date_of_birth', $params['date_of_birth'], PDO::PARAM_STR);
			$stmt->bindParam(':gender', $params['gender'], PDO::PARAM_INT); // PDO::PARAM_INT is used for treating $params['active'] as Integer
			
			if (!$stmt->execute()) {
				echo "Execute failed: (" . $stmt->errno . ")" . $stmt->errno;
				return false;
			}
			 
			$this->pdo = null;
			 
			return true;
		}
		catch (PDOException $e) {
			print "User creation failed!: " . $e->getMessage() . "<br/>";
		}
		return false;
	}

	/*
	 * @function: This is the the function which is responsible for reading a single entry from a table.
	 *
	 * @arguments: $query
	 * @return : single stdClass Object array.
	 */
	public function read($query) {
		try {
			$this->pdo = $this->connectMySql();

			$stmt = $this->pdo->prepare($query);
	 
			if (!$stmt->execute()) {
				echo "Execute failed: (" .$stmt->errno . ")" . $stmt->errno;
				return false;
			}
			 
			$nart = $stmt->rowCount();
			 
			if ($nart == 0) {
				echo "Query failed: (" .$stmt->errno . ")" . $stmt->errno;
				return "No Entry found in table";
			}
			 
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			 
			$this->pdo = null;
			 
			return $this->result;
		}
		catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
		}
		return null;
	}

} 

?>