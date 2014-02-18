<?php
header("Access-Control-Allow-Origin: *");

include('query.php');

$email = $_POST['email'];
$password = $_POST['password'];

// Define a SQL statement that can retreive the user's email and password.
$sqlParams =array(
	'SELECT' => array('password'),
	'FROM' => array('user'),
  	'WHERE' => array('email' => null)
);
$dataParams =array
(
	'email' => $email
);

$result = query($sqlParams, $dataParams);
// echo ($result->password);

if ($result->password === $password) {
	// header('Content-Type: application/json');
	echo json_encode($result->password);
	
}
else {
	// header('HTTP/1.1 500 Internal Server Booboo');
	// header('Content-Type: application/json');
	echo json_encode("wrong password");
	// die('ERROR');
}

?>