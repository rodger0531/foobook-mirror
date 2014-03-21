<?php

include '../../functions/abstract/query.php';

$thread_id = $_POST['thread_id'];

// Define which type of database transaction is being attempted here, e.g. CREATE, READ, etc.
$action = 2; //Reading data from the database.

$query = "
SELECT user.first_name, user.last_name, photo.photo_content, T1.thread_name, T1.message_string, T1.created, T1.thread_id,T1.sender_id, T1.message_id
FROM
(
SELECT t.thread_name, m.message_string, m.created, m.thread_id, m.sender_id, m.message_id
FROM message m
INNER JOIN thread t 
ON m.thread_id = t.thread_id
WHERE t.thread_id = :thread_id
) AS T1
JOIN user
ON user.user_id = T1.sender_id
JOIN photo
ON photo.photo_id = user.profile_picture_id
";

$params = array(
	'thread_id' => $thread_id
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
		$result['response'] = "There is not thread associated with this thread ID!";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
	echo json_encode($result);
}
elseif ($result['outcome'] === 1) //On success, a for loop encodes all the pictures in the returned responce.
{
	$size = sizeof($result['response']);
	for ($i = 0; $i < $size; $i++)
	{
		$result['response'][$i]->photo_content = base64_encode($result['response'][$i]->photo_content);
	}
}
echo json_encode($result['response']);

?>