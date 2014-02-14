<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the User_block class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class User_block extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating User_block entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "INSERT INTO user_block SET
				block_id = :block_id,
				user_id = :user_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':block_id', $params['block_id'], PDO::PARAM_STR); 
			$stmt->bindParam(':user_id', $params['user_id'], PDO::PARAM_INT); 
			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "User_block record was successfully created!";
		}
		catch (PDOException $e) {
			return "User_block could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single User_block record.
	 *
	 * @argument: $params - id of the User_block record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM user_block WHERE user_id = :user_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':user_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no User_block associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = $this->result->block_id;

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "User_block record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing User_block records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	// public function update($params){
	// 	try {
	// 		$this->pdo = $this->connectMySql();
			
	// 		$query = "UPDATE user_block SET
	// 			block_id = :block_id,
	// 			user_id = :user_id
	// 			WHERE
	// 			user_id = :user_id";
			
	// 		$stmt = $this->pdo->prepare($query);
			
	// 		$stmt->bindParam(':user_id',$params['user_id'], PDO::PARAM_INT);
	// 		$stmt->bindParam(':block_id', $params['block_id'], PDO::PARAM_STR); 

	// 		if (!$stmt->execute()) {
	// 			return "Update query could not be executed!";
	// 		}
			
	// 		$this->pdo = null; // Resetting the PDO object.

	// 		return "User_block record was successfully updated!";
	// 	}
	// 	catch (PDOException $e) {
	// 		return "User_block record could not be updated: " . $e->getMessage() . "<br/>";
	// 	}
	// }
	 
	/*
	 * @function: This is the the function which is responsible for deleting User_block entries.
	 *
	 * @argument: $User_block_id - id of the User_block record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM user_block WHERE user_id = :user_id AND block_id = :block_id";
			
			$stmt = $this->pdo->prepare($query);
	
			$stmt->bindParam(':block_id', $params['block_id'], PDO::PARAM_STR); 
			$stmt->bindParam(':user_id', $params['user_id'], PDO::PARAM_INT); 
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "User_block record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "User_block record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	
}

// Create a new User_block object.
$User_block = new User_block();

// $test = 1;
// switch($test) {
switch($_POST['action']) {
	case 1: //Creates a new user_block entry in "user_block" table.
		$params = array(
			'block_id' => $_POST['block_id'],
			'user_id' => $_POST['user_id']
		);
		echo json_encode($User_block->create($params));
		break;
	case 2: //Reads a single user_block entry from "user_block" table.
		$params = $_POST['user_id'];
		echo json_encode($User_block->read($params));
		break;
	// case 3: //Updates existing entries in "user_block" table.
	// 	$params = array(
	// 		'user_block_id'=> $_POST['user_block_id'],
	// 		'block_id' => $_POST['block_id'],
	// 		'user_id' => $_POST['user_id']
	// 	);
	// 	echo json_encode($User_block->update($params));
	// 	break;
	case 4: // Deletes user_block entries from "user_block" table.
		$params = array(
			'block_id' => $_POST['block_id'],
			'user_id' => $_POST['user_id']
		);
	 	echo json_encode($User_block->delete($params));
	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>