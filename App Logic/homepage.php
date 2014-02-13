<?php

// Enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
// The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
header("Access-Control-Allow-Origin: *");

// Include the file containing the database connection class - which the below class will extend.
include 'db_connect.php';
 
/*
 * @author: Philip, Tharman, Rodger and Abdi.
 *
 * @class: This is the Homepage class. This class is responsible for handling news feed
 * related queries with the database using PHP Data Object (PDO) with Prepared Statement.
 */
class Homepage extends DB {

	private $pdo;
	public  $result;
	 
	public function __construct(){}

	/*
	 * @function: This is responsible for populating the news feed with posts and comments from
	 * the user's wall, their friends' walls, and their group walls.
	 */
	public function populateNewFeed($user_id){
		try {
			$this->pdo = $this->connectMySql();

			$query =
				"SELECT sender_id, post, timestamp, visiblity_setting
				FROM user_userWallPost
				INNER JOIN userWallPost
				ON user_userWallPost.post_id = userWallPost.post_id
				WHERE user_id = :user_id OR user_id
				IN (
					SELECT friend_id
					FROM user_friend
					WHERE user_id = :user_id
				)
				UNION
				SELECT sender_id, post, timestamp, visiblity_setting
				FROM groupsWallPost
				WHERE groups_id
				IN (
					SELECT groups_id
					FROM user_groups
					WHERE user_id = :user_id
				)
				ORDER BY timestamp DESC
				LIMIT 0,10";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Query was successful!";
		}
		catch (PDOException $e) {
			return "PDO exception: " . $e->getMessage() . "<br/>";
		}
	}

	function getPostComments($post_id) {
		try {
			$this->pdo = $this->connectMySql();

			$query =
				"SELECT sender_id, post, timestamp, visiblity_setting
				FROM userWallPostComment, groupWallPostComment
				WHERE post_id = :post_id
				ORDER BY timestamp ASC";
			
			$stmt = $this->pdo->prepare($query);
			
			$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
			
			if (!$stmt->execute()) {
				return "Query could not be executed!";
			}
			
			$this->pdo = null; // Resetting the PDO object.

			return "Query was successful!";
		}
		catch (PDOException $e) {
			return "PDO exception: " . $e->getMessage() . "<br/>";
		}
	}
	
}

// TESTING

		// Create a new Homepage object.
		$homepage = new Homepage();
		echo json_encode($homepage->populateNewFeed(1));
		echo json_encode($homepage->getPostComments(1));

?>