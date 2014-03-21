<?php

include '../../functions/abstract/query.php';

include '../../pages/landing/password.php';

$user_id = $_POST['user_id'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$password = $_POST['password'];
$city = $_POST['city'];
$country = $_POST['country'];
$school_name = $_POST['school_name'];
$employer_name = $_POST['employer_name'];

$action = 3;

$hash = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12)); // Use bcrypt algorithm to hash the password.

// Verify that the password has been correctly hashed.
if (!password_verify($password, $hash))
{
	die;
}
if(!empty($password))
{
	$query = "
	UPDATE user u
	INNER JOIN user_school us
	ON u.user_id = us.user_id
	INNER JOIN school s
	ON us.school_id = s.school_id
	INNER JOIN user_employer ue
	ON u.user_id = ue.user_id
	INNER JOIN employer e
	ON ue.employer_id = e.employer_id
	SET u.first_name = :first_name,
		u.middle_name = :middle_name,
		u.last_name = :last_name, 
		u.password = :password, 
		u.city = :city,
		u.country = :country,
		s.school_name = :school_name,
		e.employer_name = :employer_name
	WHERE u.user_id = :user_id
	";
}
elseif(empty($password))
{
	$query = "
	UPDATE user u
	INNER JOIN user_school us
	ON u.user_id = us.user_id
	INNER JOIN school s
	ON us.school_id = s.school_id
	INNER JOIN user_employer ue
	ON u.user_id = ue.user_id
	INNER JOIN employer e
	ON ue.employer_id = e.employer_id
	SET u.first_name = :first_name,
		u.middle_name = :middle_name,
		u.last_name = :last_name, 
		u.city = :city,
		u.country = :country,
		s.school_name = :school_name,
		e.employer_name = :employer_name
	WHERE u.user_id = :user_id
	";
}

if(empty($first_name))
{
	$first_name = "";
}

if(empty($middle_name))
{
	$middle_name = "";
}

if(empty($last_name))
{
	$last_name = "";
}

if(empty($city))
{
	$city = "";
}

if(empty($country))
{
	$country = "";
}

if(empty($school_name))
{
	$school_name = "";
}

if(empty($employer_name))
{
	$employer_name = "";
}

if(empty($password))
{
	$params = 
	array(
		'user_id' => $user_id,
		'first_name' => $first_name,
		'middle_name' => $middle_name,
		'last_name' => $last_name,
		'city' => $city,
		'country' => $country,
		'school_name' => $school_name,
		'employer_name' => $employer_name
	);
}
elseif(!empty($password))
{
	$params = 
	array(
		'user_id' => $user_id,
		'first_name' => $first_name,
		'middle_name' => $middle_name,
		'last_name' => $last_name,
		'password' => $hash, 
		'city' => $city,
		'country' => $country,
		'school_name' => $school_name,
		'employer_name' => $employer_name
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
	echo json_encode($result['response']);
}

?>