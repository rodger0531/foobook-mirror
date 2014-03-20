<?php

require '../../functions/abstract/query.php'; // For querying to the database.

$user_id = $_POST['user_id'];
$friend_id = $_POST['friend_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define the SQL query.
$query = "
SELECT
	COUNT(*) AS countOf
FROM
	user_friend
WHERE
	(user_id = :user_id AND friend_id = :friend_id)
	OR (user_id = :user_id_2 AND friend_id = :friend_id_2)
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id' => $user_id,
	'user_id_2' => $friend_id,
	'friend_id' => $friend_id,
	'friend_id_2' => $user_id
);

$result = query($action, $query, $params);

echo json_encode($result);

?>