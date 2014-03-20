<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$user_id = $_POST['user_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	u.first_name, u.middle_name, u.last_name, u.date_of_birth,
	p.photo_content AS profile_picture,
	s.school_name,
	e.employer_name
FROM
	user u
	LEFT JOIN photo p
		ON p.photo_id = u.profile_picture_id
	LEFT JOIN user_school us
		ON us.user_id = u.user_id
	LEFT JOIN school s
		ON s.school_id = us.school_id
	LEFT JOIN user_employer ue
		ON ue.user_id = u.user_id
	LEFT JOIN employer e
		ON e.employer_id = ue.employer_id
WHERE
	u.user_id = :user_id
ORDER BY
	us.end_date DESC,
	ue.end_date DESC
LIMIT 1
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id' => $user_id
);

$result = query($action, $query, $params);

foreach ($result['response'] as $element)
{
	$element->profile_picture = base64_encode($element->profile_picture);
}

echo json_encode($result);

?>