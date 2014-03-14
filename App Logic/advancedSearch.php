<?php

include 'query.php';

$school = $_POST['school'];
$employer = $_POST['employer'];
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
	AND e.employer_name = :employer_name";
}

if(!empty($school))
{
	$query .= "
	INNER JOIN user_school us
	ON u.user_id = us.user_id
	INNER JOIN school s
	ON us.school_id = s.school_id
	AND s.school_name = :school_name
	";
}

if(!empty($city) && empty($country))
{
	$query .= " WHERE u.city = :city";
}

if(!empty($country) && empty($city))
{
	$query .= " WHERE u.country = :country";
}

if(!empty($city) && !empty($country))
{
	$query .= "
	WHERE u.city = :city
	AND u.country = :country";
}

if(!empty($city) && empty($country) && empty($employer) && empty($school))
{
	$params = 
	array(
		'city' => $city
	);
}

if(!empty($country) && empty($city) && empty($employer) && empty($school))
{
	$params = 
	array(
		'country' => $country
	);
}

if(!empty($employer) && empty($country) && empty($city) && empty($school))
{
	$params = 
	array(
		'employer_name' => $employer
	);
}

if(!empty($school) && empty($country) && empty($employer) && empty($city))
{
	$params = 
	array(
		'school_name' => $school
	);
}

if(!empty($city) && !empty($country) && empty($school) && empty($employer))
{
	$params = 
	array(
		'city' => $city,
		'country' => $country
	);
}

if(!empty($city) && !empty($employer) && empty($country) && empty($school))
{
	$params = 
	array(
		'city' => $city,
		'employer_name' => $employer
	);
}

if(!empty($city) && !empty($school) && empty($country) && empty($employer))
{
	$params = 
	array(
		'city' => $city,
		'school_name' => $school
	);
}

if(!empty($country) && !empty($employer) && empty($city) && empty($school))
{
	$params = 
	array(
		'country' => $country,
		'employer_name' => $employer
	);
}

if(!empty($country) && !empty($school) && empty($city) && empty($employer))
{
	$params = 
	array(
		'country' => $country,
		'school_name' => $school
	);
}

if(!empty($employer) && !empty($school)  && empty($country) && empty($city))
{
	$params = 
	array(
		'employer_name' => $employer,
		'school_name' => $school
	);
}

if(!empty($city) && !empty($country) && !empty($employer) && empty($school))
{
	$params = 
	array(
		'city' => $city,
		'country' => $country,
		'employer_name' => $employer
	);
}

if(!empty($city) && !empty($country) && !empty($school) && empty($employer))
{
	$params = 
	array(
		'city' => $city,
		'country' => $country,
		'school_name' => $school
	);
}

if(!empty($city) && !empty($employer) && !empty($school) && empty($country))
{
	$params = 
	array(
		'city' => $city,
		'employer_name' => $employer,
		'school_name' => $school
	);
}

if(!empty($country) && !empty($employer) && !empty($school) && !empty($city))
{
	$params = 
	array(
		'country' => $country,
		'employer_name' => $employer,
		'school_name' => $school,
		'city' => $city
	);
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