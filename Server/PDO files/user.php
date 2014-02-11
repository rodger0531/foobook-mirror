<?php
	
header("Access-Control-Allow-Origin: *");
	
	require_once __DIR__ . '/crud.php';

	$db = new CRUD();

	/* Testing out the 'create' function. */

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$date_of_birth = $_POST['date_of_birth'];
	$gender = $_POST['gender'];

	create($db, $first_name, $last_name, $email, $password, $date_of_birth, $gender);

	function read($db, $user_id) {
		$query = "SELECT * FROM user WHERE user_id = $user_id"; 
		$result = $db->read($query);
		$response = array();
		$response["user_id"] = $result->user_id;
		$response["first_name"] = $result->first_name;
		echo json_encode($response);
	}

	function create($db, $first_name, $last_name, $email, $password, $date_of_birth, $gender) {
		
		$params = array(
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email' => $email,
			'password' => $password,
			'date_of_birth' => $date_of_birth,
			'gender' => $gender
		);

		$result = $db->create($params);
		echo json_encode($result);
	}
	
?>