<?php

include 'query.php';

$collection_id = $_POST['collection_id'];

$photo_type = $_FILES['photo_content']['type'];

if (substr($photo_type, 0, 5) !== "image")
{
	echo json_encode("Only images can be uploaded!");
	return;
}

$photo_content = file_get_contents($_FILES['photo_content']['tmp_name']);

$action = 1;

$query = "
INSERT INTO photo
SET collection_id = :collection_id,
	photo_content = :photo_content
";

$params = 
array(
	'collection_id' => $collection_id,
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
	$result['response'] = $collection_id;
	echo json_encode($result['response']);
}


?>