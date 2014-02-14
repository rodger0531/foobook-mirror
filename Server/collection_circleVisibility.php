<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the collection_circleVisibility class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class Collection_CircleVisibility extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating collection_circleVisibility entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
		
			$query = "INSERT INTO collection_circleVisibility
					  SET collection_id = :collection_id,
					  	  visibility_setting = :visibility_setting,
					  	  circle_id = :circle_id";

			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':collection_id', $params['collection_id'], PDO::PARAM_INT);
			$stmt->bindParam(':visibility_setting', $params['visibility_setting'], PDO::PARAM_INT);
			$stmt->bindParam(':circle_id', $params['circle_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "collection_circleVisibility record was successfully created!";
		}
		catch (PDOException $e) {
			return "collection_circleVisibility could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single collection_circleVisibility record.
	 *
	 * @argument: $params - id of the collection_circleVisibility record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM collection_circleVisibility WHERE collection_id = :collection_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':collection_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no collection_circleVisibility associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'circle_id' => $this->result->circle_id,
				'visibility_setting' => $this->result->visibility_setting
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "collection_circleVisibility record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing collection_circleVisibility records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE collection_circleVisibility SET
				visibility_setting = :visibility_setting,
				WHERE
				collection_id = :collection_id,
				circle_id = :circle_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':collection_id',$params['collection_id'], PDO::PARAM_INT);
			$stmt->bindParam(':circle_id', $params['circle_id'], PDO::PARAM_INT); 
			$stmt->bindParam(':visibility_setting', $params['visibility_setting'], PDO::PARAM_STR); 

			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "collection_circleVisibility record was successfully updated!";
		}
		catch (PDOException $e) {
			return "collection_circleVisibility record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting collection_circleVisibility entries.
	 *
	 * @argument: $collection_circleVisibility_id - id of the collection_circleVisibility record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM collection_circleVisibility WHERE collection_id = :collection_id, circle_id = :circle_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':collection_id', $params['collection_id'], PDO::PARAM_INT);
			$stmt->bindParam(':circle_id', $params['circle_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "collection_circleVisibility record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "collection_circleVisibility record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new collection_circleVisibility object.
$Collection_CircleVisibility = new Collection_CircleVisibility();


switch($_POST['action']) {
	case 1: //Creates a new collection entry in "collection" table.
		$params = array(
			'collection_id' => $_POST['collection_id'],
			'visibility_setting' => $_POST['visibility_setting'],
			'circle_id' => $_POST['circle_id']
		);
		echo json_encode($collection_circleVisibility->create($params));
		break;
	case 2: //Reads a single collection entry from "collection" table.
		$params = array(
			 'collection_id' => $_POST['collection_id']
		);
		echo json_encode($collection_circleVisibility->read($params));
		break;
	case 3: //Updates existing entries in "collection" table.
		$params = array(
			 'visibility_setting' => $_POST['visibility_setting']
		);
		echo json_encode($collection_circleVisibility->update($params));
		break;
//	case 4: // Deletes collection entries from "collection" table.
//		$params = array(
			// 'collection_id' => $_POST['collection_id'], 
			// 'circle_id' => $_POST['circle_id']
		//)
//	 	echo json_encode($collection_circleVisibility->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>