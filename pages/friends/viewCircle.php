<?php

include '../../functions/abstract/query.php';
$user_id = $_POST['user_id'];
$action = 2;
// Define a SQL query so that server can insert a friend into a circle.
$query = "
SELECT circle_name, circle_id
FROM circle
WHERE owner_id = :user_id
";

// Define the parameters of the query depending on the information the user input.
$params =
array(
	'user_id'=> $user_id
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