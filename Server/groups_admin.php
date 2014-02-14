<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the Groups_Admin class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class Groups_Admin extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating groups_admin entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "INSERT INTO groups_admin SET
				groups_id = :groups_id,
				admin_id = :admin_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':groups_id', $params['groups_id'], PDO::PARAM_INT);
			$stmt->bindParam(':admin_id', $params['admin_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Groups_Admin record was successfully created!";
		}
		catch (PDOException $e) {
			return "Groups_Admin could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single groups_admin record.
	 *
	 * @argument: $params - id of the groups_id record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM groups_admin WHERE groups_id = :groups_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':groups_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no groups_id associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'admin_id' => $this->result->admin_id
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "Groups_Admin record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing groups_admin records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE groups_admin SET
				admin_id = :admin_id
				WHERE
				groups_id = :groups_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':groups_id',$params['groups_id'], PDO::PARAM_INT);
			$stmt->bindParam(':admin_id', $params['admin_id'], PDO::PARAM_STR); 

			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Groups_Admin record was successfully updated!";
		}
		catch (PDOException $e) {
			return "Groups_Admin record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting groups_admin entries.
	 *
	 * @argument: $groups_id - id of the groups_id record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM groups_admin WHERE groups_id = :groups_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':groups_id', $params['groups_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "Groups_Admin record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "Groups_Admin record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new Groups_Admin object.
$groups_admin = new Groups_Admin();

switch($_POST['action']) {
	case 1: //Creates a new Groups_Admin entry in "Groups_Admin" table.
		$params = array(
			'groups_id' => $_POST['groups_id'],
			'admin_id' => $_POST['admin_id']
		);
		echo json_encode($groups_admin->create($params));
		break;
	case 2: //Reads a single Groups_Admin entry from "Groups_Admin" table.
		$params = $_POST['groups_id'];
		echo json_encode($groups_admin->read($params));
		break;
	case 3: //Updates existing entries in "groups_admin" table. 
		$params = array(
			'groups_id' => $_POST['groups_id'],
			'admin_id' => $_POST['admin_id']
		);
		echo json_encode($groups_admin->update($params));
		break;
//	case 4: // Deletes groups_admin entries from "groups_admin" table.
//		$params = $_POST['groups_admin'];
//	 	echo json_encode($groups_admin->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>