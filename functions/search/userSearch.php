<?php

include '../../functions/abstract/query.php';

$user_input = $_POST['search'];

$action = 2;

$query = "
SELECT user_id, first_name, middle_name, last_name, photo_content
FROM user, photo
WHERE user.profile_picture_id = photo.photo_id
";

if(preg_match('/\s/', $user_input))
{
	$keywords = preg_split("/\s/", $user_input);
	$input = $keywords[1];

	if(sizeof($keywords) === 2)
	{
		$query .= "
		AND first_name = :first_name 
		AND (middle_name LIKE '%$input%' OR last_name LIKE '%$input%')
		LIMIT 5;
		";

		$params = 
		array(
			'first_name' => $keywords[0]
		);
	}
	elseif(sizeof($keywords) === 3)
	{
		$query = "
		AND first_name = :first_name 
		AND middle_name = :middle_name 
		AND (last_name = :last_name OR last_name LIKE '%$input%')
		LIMIT 
		";

		$params = 
		array(
			'first_name' => $keywords[0],
			'middle_name' => $keywords[1],
			'last_name' => $keywords[1]
		);
	}
}
elseif(!preg_match('/\s/', $user_input))
{
	$query .= "AND (user.first_name LIKE '%$user_input%' or user.middle_name LIKE '%$user_input%' or user.last_name LIKE '%$user_input%')
	LIMIT 5;";

	$params = array();
}

$result = query($action, $query, $params);

if ($result['outcome'] === 0)
{
	if ($result['response'] === 201)
	{
		$result['response'] = "Query could not be executed!";
	}
	elseif ($result['response'] === 202)
	{
		$result['response'] = "There is no account associated with the given user_id!"; // need to change this 
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
		$result['response'][$x]->photo_content = base64_encode($user->photo_content);
		if($user->middle_name === null){
			$result['response'][$x]->middle_name = "";
		}
		$x++;
	}

	echo json_encode($result['response']);
}

?>