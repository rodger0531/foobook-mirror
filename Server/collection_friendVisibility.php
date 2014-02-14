<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the collection_friendVisibility class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class Collection_FriendVisibility extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating collection_friendVisibility entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
		try {
			$this->pdo = $this->connectMySql();
		
			$query = "INSERT INTO collection_friendVisibility
					  SET collection_id = :collection_id,
					  	  visibility_setting = :visibility_setting,
					  	  friend_id = :friend_id";

			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':collection_id', $params['collection_id'], PDO::PARAM_INT);
			$stmt->bindParam(':visibility_setting', $params['visibility_setting'], PDO::PARAM_INT);
			$stmt->bindParam(':friend_id', $params['friend_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Collection_FriendVisibility record was successfully created!";
		}
		catch (PDOException $e) {
			return "Collection_FriendVisibility could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single collection_friendVisibility record.
	 *
	 * @argument: $params - id of the collection_friendVisibility record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM collection_friendVisibility WHERE collection_id = :collection_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':collection_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no collection_friendVisibility associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'friend_id' => $this->result->friend_id,
				'visibility_setting' => $this->result->visibility_setting
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "Collection_FriendVisibility record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing collection_friendVisibility records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE collection_friendVisibility SET
				visibility_setting = :visibility_setting,
				WHERE
				collection_id = :collection_id,
				friend_id = :friend_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':collection_id',$params['collection_id'], PDO::PARAM_INT);
			$stmt->bindParam(':friend_id', $params['friend_id'], PDO::PARAM_INT); 
			$stmt->bindParam(':visibility_setting', $params['visibility_setting'], PDO::PARAM_STR); 

			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Collection_FriendVisibility record was successfully updated!";
		}
		catch (PDOException $e) {
			return "Collection_FriendVisibility record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting collection_friendVisibility entries.
	 *
	 * @argument: $collection_friendVisibility_id - id of the collection_friendVisibility record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM collection_friendVisibility WHERE collection_id = :collection_id, friend_id = :friend_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':collection_id', $params['collection_id'], PDO::PARAM_INT);
			$stmt->bindParam(':friend_id', $params['friend_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "Collection_FriendVisibility record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "Collection_FriendVisibility record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new collection_friendVisibility object.
$Collection_FriendVisibility = new Collection_FriendVisibility();


switch($_POST['action']) {
	case 1: //Creates a new collection entry in "collection" table.
		$params = array(
			'collection_id' => $_POST['collection_id'],
			'visibility_setting' => $_POST['visibility_setting'],
			'friend_id' => $_POST['friend_id']
		);
		echo json_encode($Collection_FriendVisibility->create($params));
		break;
	case 2: //Reads a single collection entry from "collection" table.
		$params = array(
			 'collection_id' => $_POST['collection_id']
		);
		echo json_encode($Collection_FriendVisibility->read($params));
		break;
	case 3: //Updates existing entries in "collection" table.
		$params = array(
			 'visibility_setting' => $_POST['visibility_setting']
		);
		echo json_encode($Collection_FriendVisibility->update($params));
		break;
//	case 4: // Deletes collection entries from "collection" table.
//		$params = array(
			// 'collection_id' => $_POST['collection_id'], 
			// 'circle_id' => $_POST['circle_id']
		//)
//	 	echo json_encode($Collection_FriendVisibility->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>