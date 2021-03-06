<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$user_id = $_POST['user_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	m.message_id, m.message_string, m.created, m.updated,
	u1.user_id AS sender_id, u1.first_name AS sender_fname, u1.middle_name AS sender_mname, u1.last_name AS sender_lname,
	p1.photo_content AS sender_picture,
	u2.user_id AS to_user_id, u2.first_name AS recipient_fname, u2.middle_name AS recipient_mname, u2.last_name AS recipient_lname,
	g.groups_id AS to_group_id, g.groups_name AS group_name,
	p2.photo_content AS uploaded_picture
FROM
	message m
	INNER JOIN
	(
		SELECT
			t1.friend_id
		FROM
			(
				SELECT friend_id
				FROM user_friend
				WHERE user_id = :user_id_1
			) AS t1
			INNER JOIN
			(
				SELECT user_id
				FROM user_friend
				WHERE friend_id = :user_id_2
			) AS t2
			ON
			t1.friend_id = t2.user_id
	) AS t3
		ON
		(
			m.userWall_id = t3.friend_id
			OR
			(
				m.sender_id = t3.friend_id
				AND
				m.userWall_id = :user_id_3
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
	m.message_id, m.message_string, m.created, m.updated,
	u1.user_id AS sender_id, u1.first_name AS sender_fname, u1.middle_name AS sender_mname, u1.last_name AS sender_lname,
	p1.photo_content AS sender_picture,
	u2.user_id AS to_user_id, u2.first_name AS recipient_fname, u2.middle_name AS recipient_mname, u2.last_name AS recipient_lname,
	g.groups_id AS to_group_id, g.groups_name AS group_name,
	p2.photo_content AS uploaded_picture
FROM
	message m
	INNER JOIN user_groups ug
		ON
		(
			ug.user_id = :user_id_4
			AND 
			ug.groups_id = m.groupWall_id
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
ORDER BY updated DESC
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id_1' => $user_id,
	'user_id_2' => $user_id,
	'user_id_3' => $user_id,
	'user_id_4' => $user_id
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