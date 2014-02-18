<?php

header("Access-Control-Allow-Origin: *");

include('query.php');

$email = $_POST['email'];
$password = $_POST['password'];

// Define a SQL statement that can retreive the user's email and password.
$sqlParams =
array(
	'SELECT' => array('password'),
	'FROM' => array('user'),
    'WHERE' => array('email' => null)
);
$dataParams =
array(
	'email' => $email
);

$result = query($sqlParams, $dataParams);

if ($result->password === $password)
{
	echo json_encode("Login successful!");
}
else
{
	echo json_encode("Incorrect password entered!");
}

?>