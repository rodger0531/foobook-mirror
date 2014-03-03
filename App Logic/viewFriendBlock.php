<?php

include 'query.php';

$user_id = $_POST['user_id'];
// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action =2;

// Define a SQL query so that server can retrieve user friend's first name, last name and profile pic.
$query = "
SELECT user.first_name, user.last_name
FROM user
INNER JOIN user_block
ON user.user_id = user_block.block_id
WHERE user_block.user_id= :user_id
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id' => $user_id
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
		$result['response'] = "There is no account associated with the given user_id!";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
	echo json_encode($result);
}
elseif ($result['outcome'] === 1)
{

	echo json_encode($result['response']);
}

?>