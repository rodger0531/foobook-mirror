<?php

require 'query.php';

$photo_id = $_POST['photo_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define a SQL query that can retreive the photo given it's id.
$query = "
SELECT photoContent, description
FROM photo
WHERE photo_id = :photo_id
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'photo_id' => $photo_id
);

$result = query($action, $query, $params);

// Alter the responses to provide feedback to the user.
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
}
elseif ($result['outcome'] === 1)
{
	$x = 0;
	foreach ($result['response'] as $photo) {
		$result['response'][$x]->photoContent = base64_encode($photo->photoContent);
		$x++;
	}
	
}

echo json_encode($result['response']);

?>