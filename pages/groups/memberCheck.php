<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$user_id = $_POST['user_id'];
$groups_id = $_POST['groups_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	COUNT(*) AS countOf
FROM
	user_groups
WHERE
	user_id = :user_id AND groups_id = :groups_id
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id' => $user_id,
	'groups_id' => $groups_id,
);

$result = query($action, $query, $params);

echo json_encode($result);

?>