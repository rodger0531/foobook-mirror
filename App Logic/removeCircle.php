<?php

include 'query.php';
$circle_id = $_POST['circle_id'];
$action = 4;
// Define a SQL query so that server can create a circle.
$query = "
DELETE FROM friend_circle
WHERE circle_id = :circle_id
";

$query2 = "
DELETE FROM circle
WHERE circle_id = :circle_id
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'circle_id'=> $circle_id
);

$result = query($action, $query, $params);

$result = query($action, $query2, $params);

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