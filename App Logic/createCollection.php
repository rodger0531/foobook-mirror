<?php

include 'query.php';

// $user_id = $_POST['user_id'];
// $collection_name = $_POST['collection_name'];

$user_id = 1;
$collection_name = "heroes";

$action = 1;

$query = "
INSERT INTO collection 
SET user_id = :user_id,
	collection_name = :collection_name
";

$params = 
array(
	'user_id' => $user_id,
	'collection_name' => $collection_name
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