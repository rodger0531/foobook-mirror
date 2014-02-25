<?php

require 'query.php'; // For querying to the database.

$collection_id = 1;
$photo_type = $_FILES['photo']['type'];

if (substr($photo_type, 0, 5) !== "image")
{
	echo json_encode("Only images can be uploaded!");
	die;
}

$photo = file_get_contents($_FILES['photo']['tmp_name']);
$description = $_POST['description'];

// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
$action = 1; // 1 indicates that a record is being INSERTED into the database.

// Define a SQL query that can create a record with the given user's details.
$query = "
INSERT INTO photo
SET collection_id = :collection_id, photo = :photo, description = :description
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'collection_id' => $collection_id,
	'photo' => $photo,
	'description' => $description
);

$result = query($action, $query, $params);

// Alter the responses to provide feedback to the user.
if ($result['outcome'] === 0)
{
	if ($result['response'] === 201)
	{
		$result['response'] = "Query could not be executed!";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
}
elseif ($result['outcome'] === 1)
{
	if ($result['response'] === 200)
	{
		$result['response'] = "Photo successfully uploaded!";
	}
}

echo json_encode($result['response']);

?>