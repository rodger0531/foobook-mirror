<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the Education class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class Education extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating Education entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
			

$query = "INSERT INTO education SET
						school_id = :school_id,
						school_name = :school_name";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':school_id', $params['school_id'], PDO::PARAM_INT); 
			$stmt->bindParam(':school_name', $params['school_name'], PDO::PARAM_STR); 

			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Education record was successfully created!";
		}
		catch (PDOException $e) {
			return "Education could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single Education record.
	 *
	 * @argument: $params - id of the Education record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM education WHERE school_id = :school_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':school_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no Education associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'school_name' => $this->result->school_name
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "Education record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing Education records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE education SET
				school_name = :school_name
				WHERE
				school_id = :school_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':school_name',$params['school_name'], PDO::PARAM_STR);
			$stmt->bindParam(':school_id', $params['school_id'], PDO::PARAM_INT); 

			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Education record was successfully updated!";
		}
		catch (PDOException $e) {
			return "Education record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting Education entries.
	 *
	 * @argument: $Education_id - id of the Education record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM education WHERE school_id = :school_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':school_id', $params['school_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "Education record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "Education record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new Education object.
$Education = new Education();

switch($_POST['action']) {
	case 1: //Creates a new education entry in "education" table.
		$params = array(
			'school_name' => $_POST['school_name'],
			'school_id' => $_POST['school_id']
		);
		echo json_encode($Education->create($params));
		break;
	case 2: //Reads a single education entry from "education" table.
		$params = $_POST['school_id'];
		echo json_encode($Education->read($params));
		break;
	case 3: //Updates existing entries in "education" table.
		$params = array(
			'school_id'=> $_POST['school_id'],
			'school_name' => $_POST['school_name']
		);
		echo json_encode($Education->update($params));
		break;
//	case 4: // Deletes education entries from "education" table.
//		$params = $_POST['school_id'];
//	 	echo json_encode($Education->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>