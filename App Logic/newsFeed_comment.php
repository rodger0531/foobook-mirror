<?php

require 'query.php'; // For querying to the database.

$user_id = $_POST['user_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	m.message_id, m.message_string, m.timestamp,
	u1.user_id AS sender_id, u1.first_name AS sender_fname, u1.middle_name AS sender_mname, u1.last_name AS sender_lname,
	p1.photo_content AS sender_picture,
	u2.user_id AS recipient_id, u2.first_name AS recipient_fname, u2.middle_name AS recipient_mname, u2.last_name AS recipient_lname,
	g.name AS group_name,
	p2.photo_content AS uploaded_picture
FROM
	message m
	INNER JOIN user_friend uf
		ON uf.user_id = :user_id_1
		AND
		(
			uf.friend_id = m.userWall_id
			OR
			(
				uf.friend_id = m.sender_id
				AND
				m.userWall_id = :user_id_2
			)
		)
	LEFT JOIN user u1
		ON m.sender_id = u1.user_id
	LEFT JOIN photo p1
		ON u1.profile_picture_id = p1.photo_id
	LEFT JOIN user u2
		ON m.userWall_id = u2.user_id
	LEFT JOIN groups g
		ON m.groupWall_id = g.groups_id
	LEFT JOIN photo p2
		ON m.photo_id = p2.photo_id
UNION
SELECT
	m.message_id, m.message_string, m.timestamp,
	u1.user_id AS sender_id, u1.first_name AS sender_fname, u1.middle_name AS sender_mname, u1.last_name AS sender_lname,
	p1.photo_content AS sender_picture,
	u2.user_id AS recipient_id, u2.first_name AS recipient_fname, u2.middle_name AS recipient_mname, u2.last_name AS recipient_lname,
	g.name AS group_name,
	p2.photo_content AS uploaded_picture
FROM
	message m
	INNER JOIN user_groups ug
		ON ug.user_id = :user_id_3
		AND ug.groups_id = m.groupWall_id
	LEFT JOIN user u1
		ON m.sender_id = u1.user_id
	LEFT JOIN photo p1
		ON u1.profile_picture_id = p1.photo_id
	LEFT JOIN user u2
		ON m.userWall_id = u2.user_id
	LEFT JOIN groups g
		ON m.groupWall_id = g.groups_id
	LEFT JOIN photo p2
		ON m.photo_id = p2.photo_id
ORDER BY timestamp DESC
LIMIT 10
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id_1' => $user_id,
	'user_id_2' => $user_id,
	'user_id_3' => $user_id
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
		$result['response'] = "Couldn't load the newsfeed!";
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