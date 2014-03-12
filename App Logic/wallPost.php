<?php

require 'query.php'; // For querying to the database.

$user_id = (int) $_POST['user_id'];
$userWall_id = (int) $_POST['userWall_id'];
$groupWall_id = (int) $_POST['groupWall_id'];

$message_string = $_POST['message_string'];

$photo_exists = false;
$photo_type = $_FILES['photo_content']['type'];
$photo_id = 0;

if ($photo_type !== '')
{
	if (substr($photo_type, 0, 5) !== "image")
	{
		echo json_encode("Only images can be uploaded!");
		return;
	}
	else
	{
		$photo_exists = true; // Mark the post as having a photo.
		$photo_content = file_get_contents($_FILES['photo_content']['tmp_name']);
	}
}

/*
 * Insert the photo into the database, if it exists.
 */

if ($photo_exists === true)
{
	/*
	 * Insert the photo into the database.
	 */

	// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
	$action = 1; // 1 indicates that a record is being INSERTED into the database.

	// Define a SQL query that can create the record.
	$query = "
	INSERT INTO photo
	SET photo_content = :photo_content
	";

	// Define the parameters of the query depending on the information the user inputted.
	$params =
	array(
		'photo_content' => $photo_content
	);

	$result = query($action, $query, $params);

	$photo_id = $result['insertId'];

	if ($result['outcome'] === 0)
	{
		die;
	}

}

/*
 * If the photo does not exist, or has not been correctly stored to the database, make sure that the message does not depend on this.
 */

if ($photo_id === 0)
{
	$photo_id = null;
}

/*
 * Insert the post into the database.
 */

// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
$action = 1; // 1 indicates that a record is being INSERTED into the database.

if ($groupWall_id === 0)
{
	// Define a SQL query that can create the record.
	$query = "
		INSERT INTO message
		SET sender_id = :sender_id,
			userWall_id = :userWall_id,
			message_string = :message_string,
			photo_id = :photo_id
		";

	// Define the parameters of the query depending on the information the user inputted.
	$params =
	array(
		'sender_id' => $user_id,
		'userWall_id' => $userWall_id,
		'message_string' => $message_string,
		'photo_id' => $photo_id
	);
}
else
{
	$query = "
		INSERT INTO message
		SET sender_id = :sender_id,
			groupWall_id = :groupWall_id,
			message_string = :message_string,
			photo_id = :photo_id
		";

	// Define the parameters of the query depending on the information the user inputted.
	$params =
	array(
		'sender_id' => $user_id,
		'groupWall_id' => $groupWall_id,
		'message_string' => $message_string,
		'photo_id' => $photo_id
	);
}

$result = query($action, $query, $params);

// Alter the responses to provide feedback to the user.
if ($result['outcome'] === 0)
{
	die;
}

echo json_encode("Success!");

?>