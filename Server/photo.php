<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the Photo class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class Photo extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating photo entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "INSERT INTO photo SET
				collection_id = :collection_id,
				name = :name,
				visibility_setting = :visibility_setting,
				photo = :photo";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':collection_id', $params['collection_id'], PDO::PARAM_INT); 
			$stmt->bindParam(':name', $params['name'], PDO::PARAM_STR);
			$stmt->bindParam(':visibility_setting' ,$params['visibility_setting'], PDO::PARAM_INT);
			$stmt->bindParam(':photo', $params['photo'], PDO::PARAM_LOB); //Allows to use large objects in the database. 
			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Photo record was successfully created!";
		}
		catch (PDOException $e) {
			return "Photo could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single photo record.
	 *
	 * @argument: $params - id of the photo record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM photo WHERE photo_id = :photo_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':photo_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no photo associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'collection_id' => $this->result->collection_id,
				'name' => $this->result->name,
				'visibility_setting' => $this->result->visibility_setting,
				'photo' => $this->result->photo
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "Photo record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing photo records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE photo SET
				collection_id = :collection_id,
				name = :name,
				visibility_setting = :visibility_setting,
				photo = :photo
				WHERE
				photo_id = :photo_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':photo_id',$params['photo_id'], PDO::PARAM_INT);
			$stmt->bindParam(':collection_id', $params['collection_id'], PDO::PARAM_INT); 
			$stmt->bindParam(':name', $params['name'], PDO::PARAM_STR);
			$stmt->bindParam(':visibility_setting', $params['visibility_setting'], PDO::PARAM_INT);
			$stmt->bindParam(':photo' ,$photoarams['photo'], PDO::PARAM_LOB);
			
			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Photo record was successfully updated!";
		}
		catch (PDOException $e) {
			return "Photo record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting photo entries.
	 *
	 * @argument: $photo_id - id of the photo record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM photo WHERE photo_id = :photo_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':photo_id', $params['photo_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "Photo record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "Photo record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new Photo object.
$photo = new Photo();

switch($_POST['action']) {
	case 1: //Creates a new photo entry in "photo" table.
		$params = array(
			'collection_id' => $_POST['collection_id'],
			'name' => $_POST['name'],
			'visibility_setting' => $_POST['visibility_setting'],
			'photo' => $_POST['photo']
			);
		echo json_encode($photo->create($params));
		break;
	case 2: //Reads a single photo entry from "photo" table.
		$params = $_POST['photo_id'];
		echo json_encode($photo->read($params));
		break;
	case 3: //Updates existing entries in "photo" table. 
		$params = array(
			'photo_id' => $_POST['photo_id'],
			'collection_id' => $_POST['collection_id'],
			'name' => $_POST['name'],
			'visibility_setting' => $_POST['visibility_setting'],
			'photo' => $_POST['photo']
		);
		echo json_encode($photo->update($params));
		break;
//	case 4: // Deletes photo entries from "photo" table.
//		$params = $_POST['photo_id'];
//	 	echo json_encode($photo->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>