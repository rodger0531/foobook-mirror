<?php

include 'query.php';
$owner_id = $_POST['owner_id'];
$circle_name = $_POST['circle_name'];
$action = 1;
// Define a SQL query so that server can create a circle.
$query = "
INSERT INTO circle
SET owner_id = :owner_id, circle_name =:circle_name
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'owner_id' => $owner_id,
	'circle_name'=> $circle_name
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