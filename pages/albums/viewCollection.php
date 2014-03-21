<?php

include '../../functions/abstract/query.php';

$user_id = $_POST['user_id'];

$action = 2;

$query = "
SELECT T1.collection_id, T1.collection_name, T1.photo_content
FROM 
	(
	SELECT c.collection_id, c.collection_name, p.photo_content
	FROM collection c
	LEFT JOIN photo p
	ON c.collection_id = p.collection_id
	WHERE user_id = :user_id 
	ORDER BY p.photo_id DESC
	) T1
GROUP BY collection_id
";

$params = 
array(
	'user_id' => $user_id
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
		$result['response'] = "There is no photo associated with the given id!";
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
	foreach ($result['response'] as $photo) {
		$result['response'][$x]->photo_content = base64_encode($photo->photo_content);
		$x++;
	}
	echo json_encode($result['response']);
}

?>