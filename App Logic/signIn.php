<?php

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

if ($result['outcome'] === 0)
{
	if ($result['response'] === 200)
	{
		$result['response'] = "Transaction was successful!";
	}
	elseif ($result['response'] === 201)
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
	if ($result['response']->password === $password)
	{
		$result['response'] = "Login successful!";
	}
	else
	{
		$result['response'] = "Incorrect password entered!";
	}
	echo json_encode($result);
}

?>