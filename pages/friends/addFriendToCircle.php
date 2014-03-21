<?php

include_once '../../functions/abstract/query.php';

$friend_id = $_POST['friend_id'];
$circle_id = $_POST['circle_id'];
$action = 1;
// Define a SQL query so that server can insert a friend into a circle.
$query = "
INSERT INTO friend_circle
SET friend_id = :friend_id, circle_id =:circle_id
";

// Define the parameters of the query depending on the information the user input.
$params =
array(
	'friend_id' => $friend_id,
	'circle_id'=> $circle_id
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