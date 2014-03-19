<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$message_id = $_POST['message_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	m.message_id, m.message_string, m.timestamp, m.comment_on_post_id,
	u.user_id AS sender_id, u.first_name AS sender_fname, u.middle_name AS sender_mname, u.last_name AS sender_lname,
	p1.photo_content AS sender_picture,
	p2.photo_content AS uploaded_picture
FROM
	message m
	LEFT JOIN user u
		ON m.sender_id = u.user_id
	LEFT JOIN photo p1
		ON u.profile_picture_id = p1.photo_id
	LEFT JOIN photo p2
		ON m.photo_id = p2.photo_id
WHERE m.comment_on_post_id = :message_id
ORDER BY timestamp ASC
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'message_id' => $message_id
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
		$result['response'] = "There are no comments for this message.";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
}
elseif ($result['outcome'] === 1)
{
	foreach ($result['response'] as $message)
	{
		$message->sender_picture = base64_encode($message->sender_picture);
		$message->uploaded_picture = base64_encode($message->uploaded_picture);
	}
}

echo json_encode($result);

?>