<?php

include_once '../../functions/abstract/query.php';

$friend_id = $_POST['friend_id'];
$circle_id = $_POST['circle_id'];
$action = 4;
// Define a SQL query so that server can create a circle.
$query = "
DELETE FROM friend_circle
WHERE friend_id=:friend_id AND circle_id = :circle_id
";

// Define the parameters of the query depending on the information the user inputted.
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