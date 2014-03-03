<?php

include 'query.php';

$user_input = $_POST['search'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define a SQL query so that server can retrieve user friend's first name, last name and profile pic.
$query = "
SELECT user.user_id, user.first_name, user.middle_name, user.last_name, photo.photoContent
FROM user, photo
WHERE user.profile_picture = photo.photo_id 
AND (user.first_name like '%$user_input%' or user.middle_name like '%$user_input%' or user.last_name like '%$user_input%')
LIMIT 5;
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'first_name' => $user_input,
	'middle_name' => $user_input,
	'last_name' => $user_input
);

$result = query($action, $query, $params);

if ($result['outcome'] === 0)
{
	if ($result['response'] === 201)
	{
		$result['response'] = "Query could not be executed!";
	}
	elseif ($result['response'] === 202)
	{
		$result['response'] = "There is no account associated with the given user_id!";
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
	foreach ($result['response'] as $user) {
		$result['response'][$x] = $user;
		$result['response'][$x]->photoContent = base64_encode($user->photoContent);
		if($user->middle_name === null){
			$result['response'][$x]->middle_name = "";
		}
		$x++;
	}

	echo json_encode($result['response']);
}



?>