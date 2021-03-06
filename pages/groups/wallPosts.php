<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$groups_id = $_POST['groups_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	m.message_id, m.message_string, m.created, m.updated,
	u1.user_id AS sender_id, u1.first_name AS sender_fname, u1.middle_name AS sender_mname, u1.last_name AS sender_lname,
	p1.photo_content AS sender_picture,
	p2.photo_content AS uploaded_picture
FROM
	message m
	LEFT JOIN user u1
		ON m.sender_id = u1.user_id
	LEFT JOIN photo p1
		ON u1.profile_picture_id = p1.photo_id
	LEFT JOIN photo p2
		ON m.photo_id = p2.photo_id
WHERE
	m.groupWall_id = :groups_id
ORDER BY updated DESC
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'groups_id' => $groups_id
);

$result = query($action, $query, $params);

if ($result['outcome'] === 1)
{
	foreach ($result['response'] as $message)
	{
		$message->sender_picture = base64_encode($message->sender_picture);
		$message->uploaded_picture = base64_encode($message->uploaded_picture);
	}
}

echo json_encode($result);

?>