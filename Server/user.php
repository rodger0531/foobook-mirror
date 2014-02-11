<?php

/*enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
*/
header("Access-Control-Allow-Origin: *");

include 'db_connect.php';	
 
/*
* @authors: Philip, Tharman, Rodger and Abdi.
*
*
* @class : This is the User class this class is responsible for 
create, read, update and delete funtionalities with database using PHP 
Data Object ( PDO ) with Prepared Statement.
*/
 
class User extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	* @function: This is the the function which is responsible for creating user entries into the Database.
	*
	* @arguments: $params: it represents an array where fields are the keys of the array and they have associated values. 
	* @return : boolean for insertion result.
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
		 
		$stmt->bindParam(':first_name', $params['first_name'], PDO::PARAM_STR); // PDO::PARAM_STR is used for treating $params['title_en'] as String
		$stmt->bindParam(':last_name', $params['last_name'], PDO::PARAM_STR);
		$stmt->bindParam(':email' ,$params['email'], PDO::PARAM_STR);
		$stmt->bindParam(':password', $params['password'], PDO::PARAM_STR);
		$stmt->bindParam(':date_of_birth', $params['date_of_birth'], PDO::PARAM_STR);
		$stmt->bindParam(':gender', $params['gender'], PDO::PARAM_INT); // PDO::PARAM_INT is used for treating $params['active'] as Integer
		 
		if(!$stmt->execute()){
		return false;
		}
		 
		$this->pdo = null; //Resetting PDO object.
		 
		return true;
		 
		} catch (PDOException $e) {
		print "User creation failed !: " . $e->getMessage() . 
		"<br/>";
		return false;
		}
	 
	}
	 
	/*
	* @function: This is the the function which is responsible for retrieving a single user record.
	*
	* @arguments: $id: id of the user table. 
	* @return : single Class Object array.
	*/
	 
	public function read($id){
	 
		try {
		$this->pdo = $this->connectMySql();
		 
		$query = "SELECT * FROM user WHERE user_id = :user_id";
		 
		$stmt = $this->pdo->prepare($query);
		 
		$stmt->bindParam(':user_id',$id, PDO::PARAM_INT);
		 
		if(!$stmt->execute()){
		return false;
		}
		 
		$resultLength = $stmt->rowCount();
		 
		if ($resultLength == 0) {
		return "No User entry found on id ".$id;
		}
		 
		$this->result = $stmt->fetch(PDO::FETCH_OBJ);
		 
		$this->pdo = null; //Resetting PDO object.
		 
		return $this->result;
		 
		} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		 
		}
		return null;
	}
	 
	/*
	* @function: This is the the function which is responsible for updating 
	existing user entries.
	*
	* @arguments: 
		$params: it represents an array where fields are the keys of the array and they have associated values. 
	* @return : boolean for insertion result.
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
		$stmt->bindParam(':first_name', $params['first_name'], PDO::PARAM_STR); // PDO::PARAM_STR is used for treating $params['title_en'] as String
		$stmt->bindParam(':middle_name', $params['middle_name'], PDO::PARAM_STR);
		$stmt->bindParam(':last_name', $params['last_name'], PDO::PARAM_STR);
		$stmt->bindParam(':email' ,$params['email'], PDO::PARAM_STR);
		$stmt->bindParam(':password', $params['password'], PDO::PARAM_STR);
		$stmt->bindParam(':date_of_birth', $params['date_of_birth'], PDO::PARAM_STR);
		$stmt->bindParam(':gender', $params['gender'], PDO::PARAM_INT); // PDO::PARAM_INT is used for treating $params['active'] as Integer
		$stmt->bindParam(':city', $params['city'], PDO::PARAM_STR);
		$stmt->bindParam(':country', $params['country'], PDO::PARAM_STR);
		$stmt->bindParam(':profile_picture', $params['profile_picture'], PDO::PARAM_STR);
		$stmt->bindParam(':profile_visibility', $params['profile_visibility'], PDO::PARAM_STR);
		$stmt->bindParam(':chat_visibility', $params['chat_visibility'], PDO::PARAM_STR);


		if(!$stmt->execute()){
		return false;
		}
		 
		$this->pdo = null;
		return true;
		 
		} catch (PDOException $e) {
		print "User entry update failed!: " . $e->getMessage() . "<br/>";
		return false;
		}
	 
	}
	 
	/*
	* @function: This is the the function which is responsible for deleting 
	user entries.
	*
	* @arguments: 
		$id: This is the id of the row which need to be deleted .
	* @return : boolean for deletion result.
	*/
	/* 
	public function delete($param){
	 
		try {
		$this->pdo = $this->connectMySql();

		$query = "DELETE FROM
		user
		WHERE
		id=:id" ;

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(':id',$id, PDO::PARAM_INT);

		if(!$stmt->execute()){
		return false;
		}
		$this->pdo = null;
		 
		} catch (PDOException $e) {
		print "User entry deletion failed !: " . $e->getMessage() . "<br/>";
		return false;
		}
		 
		return true;
	}
	*/

	
}

			$testUser = new User();
/*
* For inserting article
*/


		/*
			
		 	$params = array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email' => $_POST['email'],
			'password' => $_POST['password'],
			'date_of_birth' =>$_POST['date_of_birth'],
			'gender'=>$_POST['gender'],
			);

			if ($testUser->create($params)) {
			echo "Successfully user Inserted";
			}else{
			echo "user Insertion is Failed ";
			}
			*/


/*
* Reading a single user!
*/
			 
			/*
			$result = $testUser->read(2);
			echo "<pre>";
			print_r($result);
			echo "</pre>";
			echo $result->last_name;
			*/


/*
* For updating user
*/
 
			/*
			$params = array(
			'user_id' => $_POST['user_id'],
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email' => $_POST['email'],
			'password' => $_POST['password'],
			'date_of_birth' =>$_POST['date_of_birth'],
			'gender'=>$_POST['gender']
			);

			if ($testUser->update($params)) {
			echo "Successfully user updated";
			}else{
			echo "User update has failed ";
			}
			*/


/*
* For delete an user //NEEDS REVIEW.
*/
 /*
if($testUser->delete()){
echo "Successfully user deleted";
}else{
echo "Users delete failed ";
}
*/

?>