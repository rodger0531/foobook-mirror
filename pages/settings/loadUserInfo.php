<?php

include '../../functions/abstract/query.php';

$user_id = $_POST['user_id'];

$action = 2;

$query = "
SELECT u.first_name, u.middle_name, u.last_name, u.email, u.city, u.country, s.school_name, e.employer_name
FROM user u
LEFT JOIN user_school us
ON u.user_id = us.user_id
LEFT JOIN school s 
ON us.school_id = s.school_id
LEFT JOIN user_employer ue
ON u.user_id = ue.user_id
LEFT JOIN employer e 
ON ue.employer_id = e.employer_id
WHERE u.user_id = :user_id
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
		$result['response'] = "Failed!";
	}
	elseif ($result['response'] === 203)
	{
		$result['response'] = "Server error!";
	}
	echo json_encode($result);
}
elseif ($result['outcome'] === 1) 
{
	if($result['response'][0]->middle_name === null){
		$result['response'][0]->middle_name = "";
	}

	echo json_encode($result['response']);
}	

?>