<?php

include('query.php');

$email = $_POST('email');
$password = $_POST('password');

// Define a SQL statement that can retreive the user's email and password.
$sqlParams =
{
	'SELECT' : ['password'],
	'FROM' : ['user'],
    'WHERE' : {'email' : null}
};
$dataParams =
{
	'email' : $email
};

$result = query($sqlParams, $dataParams)->password;

if ($result === $password) {
	header('Content-Type: application/json');
	echo json_encode($result);
}
else {
	header('HTTP/1.1 500 Internal Server Booboo');
	header('Content-Type: application/json');
	die('ERROR');
}

?>