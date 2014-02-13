<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the User class. This class is responsible for create, read, update and delete
 * funtionalities with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class User extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating user entries into the Database.
	*
	* @argument: $params - represents an array where fields are the keys of the array and they have associated values. 
	* @return: a boolean for the insertion result.
	*/
	public function create($params){
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
			
			$stmt->bindParam(':first_name', $params['first_name'], PDO::PARAM_STR); // PDO::PARAM_STR is used for treating $params['first_name'] as String
			$stmt->bindParam(':last_name', $params['last_name'], PDO::PARAM_STR);
			$stmt->bindParam(':email' ,$params['email'], PDO::PARAM_STR);
			$stmt->bindParam(':password', $params['password'], PDO::PARAM_STR);
			$stmt->bindParam(':date_of_birth', $params['date_of_birth'], PDO::PARAM_STR);
			$stmt->bindParam(':gender', $params['gender'], PDO::PARAM_INT); // PDO::PARAM_INT is used for treating $params['gender'] as Integer
			
			if (!$stmt->execute()) {
				return "Create query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "User record was successfully created!";
		}
		catch (PDOException $e) {
			return "User could not be created: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for retrieving a single user record.
	 *
	 * @argument: $params - id of the user record to retrieve.
	 * @return: a single class object array.
	 */
	public function read($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "SELECT * FROM user WHERE user_id = :user_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':user_id', $params, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Read query could not be executed!";
			}
			
			$resultLength = $stmt->rowCount();
			
			if ($resultLength == 0) {
				return "There is no user associated with the given id: " . $params;
			}
			
			$this->result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// Store the query results in an array.
			$resultArray = array(
				'first_name' => $this->result->first_name,
				'middle_name' => $this->result->middle_name,
				'last_name' => $this->result->last_name,
				'email' => $this->result->email,
				'password' => $this->result->password,
				'date_of_birth' => $this->result->date_of_birth,
				'gender' => $this->result->gender,
				'city' => $this->result->city,
				'country' => $this->result->country,
				'profile_picture' => $this->result->profile_picture,
				'profile_visibility' => $this->result->profile_visibility,
				'chat_visibility' => $this->result->chat_visibility
			);

			$this->pdo = null; // Resetting the PDO object.

			return $resultArray;
		}
		catch (PDOException $e) {
			return "User record could not be read: " . $e->getMessage() . "<br/>";
		}
	}
	
	/*
	 * @function: This is the the function which is responsible for updating existing user records.
	 *
	 * @argument: $params - represents an array in which fields are the keys of the array, and they have associated values. 
	 * @return : a boolean for the update result.
	 */
	public function update($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "UPDATE user SET
				first_name = :first_name,
				middle_name = :middle_name,
				last_name = :last_name,
				email = :email,
				password = :password,
				date_of_birth = :date_of_birth,
				gender = :gender,
				city = :city,
				country = :country,
				profile_picture = :profile_picture,
				profile_visibility = :profile_visibility,
				chat_visibility = :chat_visibility
				WHERE
				user_id = :user_id";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':user_id',$params['user_id'], PDO::PARAM_INT);
			$stmt->bindParam(':first_name', $params['first_name'], PDO::PARAM_STR); // PDO::PARAM_STR is used for treating $params['first_name'] as String
			$stmt->bindParam(':middle_name', $params['middle_name'], PDO::PARAM_STR);
			$stmt->bindParam(':last_name', $params['last_name'], PDO::PARAM_STR);
			$stmt->bindParam(':email' ,$params['email'], PDO::PARAM_STR);
			$stmt->bindParam(':password', $params['password'], PDO::PARAM_STR);
			$stmt->bindParam(':date_of_birth', $params['date_of_birth'], PDO::PARAM_STR);
			$stmt->bindParam(':gender', $params['gender'], PDO::PARAM_INT); // PDO::PARAM_INT is used for treating $params['gender'] as Integer
			$stmt->bindParam(':city', $params['city'], PDO::PARAM_STR);
			$stmt->bindParam(':country', $params['country'], PDO::PARAM_STR);
			$stmt->bindParam(':profile_picture', $params['profile_picture'], PDO::PARAM_STR);
			$stmt->bindParam(':profile_visibility', $params['profile_visibility'], PDO::PARAM_STR);
			$stmt->bindParam(':chat_visibility', $params['chat_visibility'], PDO::PARAM_STR);

			if (!$stmt->execute()) {
				return "Update query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "User record was successfully updated!";
		}
		catch (PDOException $e) {
			return "User record could not be updated: " . $e->getMessage() . "<br/>";
		}
	}
	 
	/*
	 * @function: This is the the function which is responsible for deleting user entries.
	 *
	 * @argument: $user_id - id of the user record to be deleted.
	 * @return : a boolean for the deletion result.
	 */
	/*
	public function delete($params){
		try {
			$this->pdo = $this->connectMySql();
			
			$query = "DELETE FROM user WHERE user_id = :user_id";
			
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':user_id', $params['user_id'], PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Delete query could not be executed!";
			}

			$this->pdo = null; // Resetting the PDO object.

			return "User record was successfully deleted!";
		}
		catch (PDOException $e) {
			return "User record could not be deleted: " . $e->getMessage() . "<br/>";
		}
	}
	*/
}

// Create a new User object.
$user = new User();

switch($_POST['action']) {
	case 1: //Creates a new user entry in "user" table.
		$params = array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email' => $_POST['email'],
			'password' => $_POST['password'],
			'date_of_birth' => $_POST['date_of_birth'],
			'gender' => $_POST['gender']
		);
		echo json_encode($user->create($params));
		break;
	case 2: //Reads a single user entry from "user" table.
		$params = $_POST['user_id'];
		echo json_encode($user->read($params));
		break;
	case 3: //Updates existing entries in "user" table. 
		$params = array(
			'user_id' => $_POST['user_id'],
			'first_name' => $_POST['first_name'],
			'middle_name' => $_POST['middle_name'],
			'last_name' => $_POST['last_name'],
			'email' => $_POST['email'],
			'password' => $_POST['password'],
			'date_of_birth' => $_POST['date_of_birth'],
			'gender' => $_POST['gender'],
			'city' => $_POST['city'],
			'country' => $_POST['country'],
			'profile_picture' => $_POST['profile_picture'],
			'profile_visibility' => $_POST['profile_visibility'],
			'chat_visibility' => $_POST['chat_visibility']
		);
		echo json_encode($user->update($params));
		break;
//	case 4: // Deletes user entries from "user" table.
//		$params = $_POST['user_id'];
//	 	echo json_encode($user->delete($params));
//	 	break;
	default:
		echo json_encode("CRUD methods are not working!");
		break;
}

?>