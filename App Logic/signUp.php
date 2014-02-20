<?php

include('query.php');

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$date_of_birth = $_POST['date_of_birth'];
$gender = $_POST['gender'];

// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
$action = 1; // 1 indicates that a record is being INSERTED into the database.

// Define a SQL query that can create a record with the given user's details.
$query = "
INSERT INTO user
SET	first_name = :first_name,
	last_name = :last_name,
	email = :email,
	password = :password,
	date_of_birth = :date_of_birth,
	gender = :gender
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'first_name' => $first_name,
	'last_name' => $last_name,
	'email' => $email,
	'password' => $password,
	'date_of_birth' => $date_of_birth,
	'gender' => $gender
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
	if ($result['response'] === 200)
	{
		$result['response'] = "Thanks for signing up " . $first_name . "!";
	}
	echo json_encode($result);
}

?>