<?php

include 'query.php';

$photo_id = $_POST['photo_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define a SQL query that can retreive the photo given it's id.
$query = "
SELECT photo, description
FROM photo
WHERE photo_id = :photo_id
";

// Define the parameters of the query depending on the information the user inputted.
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
		$result['response'] = "There is no photo associated with the given id!";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
	echo json_encode($result);
}
elseif ($result['outcome'] === 1)
{
	$result['response']->photo = base64_encode($result['response']->photo);
	echo json_encode($result['response']);
}

?>