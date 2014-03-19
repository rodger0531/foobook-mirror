<?php

include '../../functions/abstract/query.php';

// $user_id = $_POST['session']; //This needs to be equal to the session id, because this is how we are going to get the user_id.

$user_id = 1;


// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; //Reading data from the database.

$query = "
Select *
FROM 
(
SELECT DISTINCT T2.thread_id, T2.timestamp, T2.message_string, thread.name, photo.photo_content
FROM message AS T2
JOIN (SELECT thread_id
FROM user_thread
WHERE user_id = :session) AS T1
ON T1.thread_id = T2.thread_id
JOIN thread
ON T2.thread_id = thread.thread_id
JOIN user
ON user.user_id = T2.sender_id
JOIN photo
ON user.profile_picture_id = photo.photo_id
ORDER BY T2.timestamp DESC
) AS T3
GROUP BY T3.thread_id
ORDER BY T3.timestamp DESC
";

$params = array(
	'session' => $user_id
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
		$result['response'] = "There is not thread associated with this user!";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
	echo json_encode($result);
}
elseif ($result['outcome'] === 1) //On success, a for loop encodes all the pictures in the returned responce.
{
	$size = (int)sizeof($result['response']);
	for ($i = 0; $i < $size; $i++)
	{
		$result['response'][$i]->photo_content = base64_encode($result['response'][$i]->photo_content);
	}
}
echo json_encode($result['response']);

?>