<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$user_id = $_POST['user_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	t1.friend_id,
	u.first_name, u.middle_name, u.last_name,
	p.photo_content AS friend_picture
FROM
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
	) AS t1
	LEFT JOIN user u
		ON u.user_id = t1.friend_id
	LEFT JOIN photo p
		ON p.photo_id = u.profile_picture_id
ORDER BY u.first_name ASC
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id_1' => $user_id,
	'user_id_2' => $user_id
);

$result = query($action, $query, $params);

foreach ($result['response'] as $element)
{
	$element->friend_picture = base64_encode($element->friend_picture);
}

echo json_encode($result);

?>