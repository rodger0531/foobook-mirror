<?php

include('query.php');

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$date_of_birth = $_POST['date_of_birth'];
$gender = $_POST['gender'];

// Define a SQL statement that can retreive the user's email and password.
$sqlParams =
array(
	'INSERT INTO' => array('user'),
	'SET' => array('first_name', 'last_name', 'email', 'password', 'date_of_birth', 'gender')
);

$dataParams =
array(
	'first_name' => $first_name,
	'last_name' => $last_name,
	'email' => $email,
	'password' => $password,
	'date_of_birth' => $date_of_birth,
	'gender' => $gender
);

$result = query($sqlParams, $dataParams);

if ($result['outcome'] === 0)
{
	if ($result['response'] === 201)
	{
		$result['response'] = "Query could not be executed!";
	}
	elseif ($result['response'] === 202)
	{
		$result['response'] = "There is no account associated with the given email!";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
	echo json_encode($result);
}
elseif ($result['outcome'] === 1)
{
	if ($result['response'] === 200)
	{
		$result['response'] = "Transaction was successful!";
	}
	echo json_encode($result);
}

?>