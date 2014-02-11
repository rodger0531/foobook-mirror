<?php

require_once __DIR__ . '/db_config.php';

// create mysqli object
$con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

// select database
$con->select_db(DB_DATABASE);

// Adding user
$first_name='Foo';
$middle_name='test';
$last_name='bar';
$email='foobar@foo.com';
$password='p4ssw0rd';
$date_of_birth='1337/05/22';
$gender=0;
$city='London';
$country='GB';
// $profile_picture='';
// $profile_visibility='';
// $chat_visibility='';

// '$first_name', '$middle_name', '$last_name', '$email', '$password', '$date_of_birth', '$gender', '$city', '$country', '$profile_picture', '$profile_visibility', '$chat_visibility'

$con->query("INSERT INTO user(first_name,
															middle_name,
															last_name,
															email,
															password,
															date_of_birth,
															gender,
															city,
															country
															)VALUES('$first_name', '$middle_name', '$last_name', '$email', '$password', '$date_of_birth', '$gender','$city','$country')") or die ($con->error);


mysqli_close($con);

?>