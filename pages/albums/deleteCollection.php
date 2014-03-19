<?php

include '../../functions/abstract/query.php';

$collection_id = $_POST['collection_id'];

$action = 4;

$query = "
DELETE FROM photo
WHERE collection_id = :collection_id
";

$params = 
array(
	'collection_id' => $collection_id
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
	$action = 4;

	$query = "
	DELETE FROM collection
	WHERE collection_id = :collection_id
	";

	$params = 
	array(
		'collection_id' => $collection_id
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

}
?>
