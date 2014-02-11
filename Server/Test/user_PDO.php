<?php
	
header("Access-Control-Allow-Origin: *");

	$response = array();
	
	require_once __DIR__ . '/connection.php';
	
	$db = new CRUD();
	$id=$_POST['user_id'];
	read($id,$db);

		function read($user_id, $db){

			$query = "SELECT * FROM user WHERE user_id = $user_id"; 
			$result = $db->readOne($query);

			$response = array('user_id'=> $result->user_id,
				'first_name' => $result->first_name
			);
			
			// print_r($response);
			echo json_encode($response);
		}
	
?>