<?php

include 'query.php';
$circle_id = $_POST['circle_id'];
// $circle_id = 1;
$action = 2;
// Define a SQL query so that server can insert a friend into a circle.
$query = "
SELECT user.first_name,user.last_name,user.user_id
FROM user
JOIN friend_circle
ON friend_circle.friend_id = user.user_id
WHERE circle_id = :circle_id
";

// Define the parameters of the query depending on the information the user input.
$params =
array(
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
		$result['response'] = "There is no account associated with the given circle_id!";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
	echo json_encode($result);
}
elseif ($result['outcome'] === 1)
{

	echo json_encode($result);
}
?>