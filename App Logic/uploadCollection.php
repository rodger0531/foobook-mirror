<?php

include 'query.php';

$collection_id = $_POST['collection_id'];
$photo_id = $_POST['photo_id'];
// $collection_id = 2;
// $photo_id = 1;

$action = 3;

$query = "
UPDATE photo
SET collection_id = :collection_id
WHERE photo_id = :photo_id
";

$params = 
array(
	'collection_id' => $collection_id,
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

	if ($result['response'] === 200)
	{
		$action = 2;

		$query = "
		SELECT collection_name
		FROM collection
		INNER JOIN photo
		ON collection.collection_id = photo.collection_id
		WHERE collection.collection_id = :collection_id
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
			$collection = $result['response'][0]->collection_name;
			$message = "Photo successfully uploaded to ".$collection."!";
			$result['response'] = $message;
		}
	}
	echo json_encode($result['response']);
}


?>