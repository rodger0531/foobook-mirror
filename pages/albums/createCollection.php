<?php

include '../../functions/abstract/query.php';

$user_id = $_POST['user_id'];
$collection_name = $_POST['collection_name'];
$photo_type = $_FILES['photo_content']['type'];

if (substr($photo_type, 0, 5) !== "image")
{
	echo json_encode("Only images can be uploaded!");
	return;
}

$photo_content = file_get_contents($_FILES['photo_content']['tmp_name']);

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


	$action = 2;

	$query = "
	SELECT collection_id
	FROM collection 
	WHERE user_id = :user_id
	ORDER BY collection_id DESC
	LIMIT 1
	";

	$params = 
	array(
		'user_id' => $user_id
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
		$action = 1;

		$query = "
		INSERT INTO photo
		SET collection_id = :collection_id,
			photo_content = :photo_content
		";

		$params = 
		array(
			'collection_id' => $result['response'][0]->collection_id,
			'photo_content' => $photo_content
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

}


?>