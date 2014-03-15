<?php

include 'query.php';

$collection_id = $_POST['collection_id'];
// $collection_id = 3;

$action = 2;

$query = "
SELECT photo_id, photo_content
FROM photo 
WHERE collection_id = :collection_id 
";

$params = 
array(
	'collection_id' => $collection_id
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
}
elseif ($result['outcome'] === 1)
{
	$x = 0;
	foreach ($result['response'] as $photo) {
		$result['response'][$x]->photoContent = base64_encode($photo->photoContent);
		$x++;
	}
	
}

echo json_encode($result['response']);

?>