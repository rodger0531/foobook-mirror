<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the Circle class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class Circle extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating circle entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "INSERT INTO circle SET
				circle_name = :circle_name,
				owner_id = :owner_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':circle_name', $params['circle_name'], PDO::PARAM_STR); // PDO::PARAM_STR is used for treating $params['title_en'] as String
			$stmt->bindParam(':owner_id', $params['owner_id'], PDO::PARAM_INT); // PDO::PARAM_INT is used for treating $params['active'] as Integer
			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Circle record was successfully created!";
		}
		catch (PDOException $e) {
			return "Circle could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single circle record.
	 *
	 * @argument: $params - id of the circle record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM circle WHERE circle_id = :circle_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':circle_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no circle associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'circle_name' => $this->result->circle_name,
				'owner_id' => $this->result->owner_id
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "Circle record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing circle records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE circle SET
				circle_name = :circle_name,
				owner_id = :owner_id
				WHERE
				circle_id = :circle_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':circle_id',$params['circle_id'], PDO::PARAM_INT);
			$stmt->bindParam(':circle_name', $params['circle_name'], PDO::PARAM_STR); // PDO::PARAM_STR is used for treating $params['title_en'] as String
			$stmt->bindParam(':owner_id', $params['owner_id'], PDO::PARAM_INT); // PDO::PARAM_INT is used for treating $params['active'] as Integer

			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Circle record was successfully updated!";
		}
		catch (PDOException $e) {
			return "Circle record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting circle entries.
	 *
	 * @argument: $circle_id - id of the circle record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM circle WHERE circle_id = :circle_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':circle_id', $params['circle_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "Circle record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "Circle record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new Circle object.
$circle = new Circle();

switch($_POST['action']) {
	case 1: //Creates a new circle entry in "circle" table.
		$params = array(
			'circle_name' => $_POST['circle_name'],
			'owner_id' => $_POST['owner_id']
		);
		echo json_encode($circle->create($params));
		break;
	case 2: //Reads a single circle entry from "circle" table.
		$params = $_POST['circle_id'];
		echo json_encode($circle->read($params));
		break;
	case 3: //Updates existing entries in "circle" table. 
		$params = array(
			'circle_id' => $_POST['circle_id'],
			'owner_id' => $_POST['owner_id']
		);
		echo json_encode($circle->update($params));
		break;
//	case 4: // Deletes circle entries from "circle" table.
//		$params = $_POST['circle_id'];
//	 	echo json_encode($circle->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>