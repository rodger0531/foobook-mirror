<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$groups_id = $_POST['groups_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	u.user_id AS member_id, u.first_name, u.middle_name, u.last_name,
	p.photo_content AS member_picture
FROM
	user u
	INNER JOIN user_groups ug
		ON
		(
			ug.user_id = u.user_id
			AND
			ug.groups_id = :groups_id
		)
	LEFT JOIN photo p
		ON p.photo_id = u.profile_picture_id
ORDER BY u.first_name, u.middle_name, u.last_name ASC
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'groups_id' => $groups_id
);

$result = query($action, $query, $params);

foreach ($result['response'] as $element)
{
	$element->member_picture = base64_encode($element->member_picture);
}

echo json_encode($result);

?>