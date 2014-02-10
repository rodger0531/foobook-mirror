<?php
	
header("Access-Control-Allow-Origin: *");

	$response = array();
	// $id=$_POST['user_id'];
	
	
	

	require_once __DIR__ . '/connection.php';
	

	$db = new CRUD();
	$id=$_POST['user_id'];
	read($id,$db);

		function read($user_id, $db){

			$user_id=user_id;
			$query = "SELECT * FROM user WHERE user_id = $user_id"; 
			$result = $db->readOne($query);
			// print_r($result);
			$response["user_id"] = $result->user_id;
			$response["first_name"] = $result->first_name;
			echo json_encode($response);
		}

	
?>