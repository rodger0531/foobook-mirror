<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$groups_id = $_POST['groups_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	g.groups_name
FROM
	groups g
WHERE
	g.groups_id = :groups_id
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'groups_id' => $groups_id
);

$result = query($action, $query, $params);

echo json_encode($result);

?>