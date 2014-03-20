<?php

include '../../functions/abstract/query.php';

$photo_id = $_POST['photo_id'];

$action = 2;

$query = "
SELECT collection_id
FROM photo
WHERE photo_id = :photo_id
";

$params = 
array(
	'photo_id' => $photo_id
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
	$collection_id = $result['response'];

	$action = 4;

	$query = "
	DELETE FROM photo
	WHERE photo_id = :photo_id
	";

	$params = 
	array(
		'photo_id' => $photo_id
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
		$result['response'] = $collection_id;
		echo json_encode($result['response'][0]->collection_id);
	}

}

?>
