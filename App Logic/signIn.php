<?php

include 'query.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define a SQL query that can retreive the user's email given their email.
$query = "
SELECT password
FROM user
WHERE email = :email
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'email' => $email
);

$result = query($action, $query, $params);

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
	if ($result['response']->password === sha1($password))
	{
		$result['response'] = "Login successful!";
	}
	else
	{
		$result['response'] = "Incorrect password entered!";
	}
	echo json_encode($result['response']);
}

?>