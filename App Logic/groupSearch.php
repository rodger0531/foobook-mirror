<?php

include 'query.php';

$user_input = $_POST['search'];
// $user_input = "f";

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define a SQL query so that server can retrieve user friend's first name, last name and profile pic.
$query = "
SELECT groups_id, groups_name
FROM groups
WHERE groups_name like '%$user_input%'
LIMIT 2;
";

// Define the parameters of the query depending on the information the user inputted.
$params = array();

$result = query($action, $query, $params);

if ($result['outcome'] === 0)
{
	if ($result['response'] === 201)
	{
		$result['response'] = "Query could not be executed!";
	}
	elseif ($result['response'] === 202)
	{
		$result['response'] = "There is no group name associated with this input";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
	echo json_encode($result);
}
elseif ($result['outcome'] === 1)
{
	$x = 0;
	foreach ($result['response'] as $group) {
		$result['response'][$x] = $group;
		$x++;
	}

	echo json_encode($result['response']);
}



?>