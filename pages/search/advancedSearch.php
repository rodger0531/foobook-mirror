<?php

include '../../functions/abstract/query.php';

$school = $_POST['school'];
$employer = $_POST['job'];
$city = $_POST['city'];
$country = $_POST['country'];

$action = 2;

$query = "
SELECT u.user_id, u.first_name, u.middle_name, u.last_name, p.photo_content "; 

$query .= "
FROM user u
INNER JOIN photo p
ON u.profile_picture_id = p.photo_id
";

if(!empty($employer))
{
	$query .= "
	INNER JOIN user_employer ue
	ON u.user_id = ue.user_id
	INNER JOIN employer e
	ON ue.employer_id = e.employer_id
	AND e.employer_name LIKE '%$employer%'
	";
}

if(!empty($school))
{
	$query .= "
	INNER JOIN user_school us
	ON u.user_id = us.user_id
	INNER JOIN school s
	ON us.school_id = s.school_id
	AND s.school_name LIKE '%$school%'
	";
}

if(!empty($city) && empty($country))
{
	$query .= " WHERE u.city LIKE '%$city%'";
}

if(!empty($country) && empty($city))
{
	$query .= " WHERE u.country LIKE '%$country%'";
}

if(!empty($city) && !empty($country))
{
	$query .= "
	WHERE u.city LIKE '%$city%'
	AND u.country LIKE '%$country%'";
}

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
	$x = 0;
	foreach ($result['response'] as $user) {
		$result['response'][$x] = $user;
		$result['response'][$x]->photo_content = base64_encode($user->photo_content);
		if($user->middle_name === null)
		{
			$result['response'][$x]->middle_name = "";
		}
		$x++;
	}
	echo json_encode($result['response']);
}	


?>