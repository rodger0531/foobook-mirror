<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the Employer class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class Employer extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating Employer entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
			

$query = "INSERT INTO employer SET
						employer_id = :employer_id,
						employer_name = :employer_name";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':employer_id', $params['employer_id'], PDO::PARAM_INT); 
			$stmt->bindParam(':employer_name', $params['employer_name'], PDO::PARAM_STR); 

			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Employer record was successfully created!";
		}
		catch (PDOException $e) {
			return "Employer could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single Employer record.
	 *
	 * @argument: $params - id of the Employer record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM employer WHERE employer_id = :employer_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':employer_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no Employer associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'employer_name' => $this->result->employer_name
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "Employer record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing Employer records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE employer SET
				employer_name = :employer_name
				WHERE
				employer_id = :employer_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':employer_name',$params['employer_name'], PDO::PARAM_STR);
			$stmt->bindParam(':employer_id', $params['employer_id'], PDO::PARAM_INT); 

			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Employer record was successfully updated!";
		}
		catch (PDOException $e) {
			return "Employer record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting Employer entries.
	 *
	 * @argument: $Employer_id - id of the Employer record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM employer WHERE employer_id = :employer_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':employer_id', $params['employer_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "Employer record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "Employer record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new Employer object.
$employer = new Employer();

switch($_POST['action']) {
	case 1: //Creates a new employer entry in "employer" table.
		$params = array(
			'employer_id' => $_POST['employer_id'],
			'employer_name' => $_POST['employer_name']
		);
		echo json_encode($employer->create($params));
		break;
	case 2: //Reads a single employer entry from "employer" table.
		$params = $_POST['employer_id'];
		echo json_encode($employer->read($params));
		break;
	case 3: //Updates existing entries in "employer" table.
		$params = array(
			'employer_id'=> $_POST['employer_id'],
			'employer_name' => $_POST['employer_name']
		);
		echo json_encode($employer->update($params));
		break;
//	case 4: // Deletes employer entries from "employer" table.
//		$params = $_POST['employer_id'];
//	 	echo json_encode($employer->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>