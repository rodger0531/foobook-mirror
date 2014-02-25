<?php

include 'query.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define a SQL query that can retreive the user's email given their email.
$query = "
SELECT salt, password
FROM user
WHERE email = :email
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'email' => $email
);


// This string tells crypt to use blowfish for 5 rounds.
$blowfish_Before = '$2a$05$';
$blowfish_After = '$';

// Assign the result to a variable so I can retrieve a row from it later on.

$row = mysql_fetch_assoc($query);

$hashed_password = crypt($password, $blowfish_Before . $row['salt'] . $blowfish_After);


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
	if ($result['response']->$hashed_password === $row['password'])
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