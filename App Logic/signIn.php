<?php

require 'password.php'; // For password hashing functions.

require 'query.php'; // For querying to the database.

if (
	empty($_POST['email'])
	|| empty($_POST['password'])
	)
{
	echo json_encode("All input fields must be completed!");
	return;
}

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

// Alter the responses to provide feedback to the user.
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
}
elseif ($result['outcome'] === 1)
{
	if (!password_verify($password, $result['response']->password))
	{
		$result['response'] = "Incorrect password entered!";
		echo json_encode($result['response']);
	}
}

?>