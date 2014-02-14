<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the GroupsWallPost_Photo class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class GroupsWallPost_Photo extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating groupsWallPost_photo entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "INSERT INTO groupsWallPost_photo SET
				post_id = :post_id,
				photo_id = :photo_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':post_id', $params['post_id'], PDO::PARAM_INT); 
			$stmt->bindParam(':photo_id', $params['photo_id'], PDO::PARAM_INT); 
			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "GroupsWallPost_Photo record was successfully created!";
		}
		catch (PDOException $e) {
			return "GroupsWallPost_Photo could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single groupsWallPost_photo record.
	 *
	 * @argument: $params - id of the groupsWallPost_photo record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM groupsWallPost_photo WHERE post_id = :post_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':post_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no groupsWallPost_photo associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'photo_id' => $this->result->photo_id,
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "GroupsWallPost_Photo record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing groupsWallPost_photo records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE groupsWallPost_photo SET
				photo_id = :photo_id
				WHERE
				post_id = :post_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':post_id',$params['post_id'], PDO::PARAM_INT);
			$stmt->bindParam(':photo_id', $params['photo_id'], PDO::PARAM_INT);

			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "GroupsWallPost_Photo record was successfully updated!";
		}
		catch (PDOException $e) {
			return "GroupsWallPost_Photo record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting groupsWallPost_photo entries.
	 *
	 * @argument: $post_id - id of the groupsWallPost_photo record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM groupsWallPost_photo WHERE post_id = :post_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':post_id', $params['post_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "GroupsWallPost_Photo record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "GroupsWallPost_Photo record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new GroupsWallPost_Photo object.
$GroupsWallPost_Photo = new GroupsWallPost_Photo();

switch($_POST['action']) {
	case 1: //Creates a new GroupsWallPost_Photo entry in "GroupsWallPost_Photo" table.
		$params = array(
			'post_id' => $_POST['post_id'],
			'photo_id' => $_POST['photo_id']
		);
		echo json_encode($GroupsWallPost_Photo->create($params));
		break;
	case 2: //Reads a single GroupsWallPost_Photo entry from "GroupsWallPost_Photo" table.
		$params = $_POST['post_id'];
		echo json_encode($GroupsWallPost_Photo->read($params));
		break;
	case 3: //Updates existing entries in "GroupsWallPost_Photo" table. 
		$params = array(
			'photo_id' => $_POST['photo_id'],
			'post_id' => $_POST['post_id']
		);
		echo json_encode($GroupsWallPost_Photo->update($params));
		break;
//	case 4: // Deletes groupsWallPost_photo entries from "groupsWallPost_photo" table.
//		$params = $_POST['groupsWallPost_photo_id'];
//	 	echo json_encode($GroupsWallPost_Photo->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>