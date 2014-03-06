<?php

include 'setup_database.php';

user('Bat','Man','alfred@batmansion.com','robin','1934/01/01','0','Gotham city','USA');
user('Super','Man','imnothere@krypton.com','kryptonite','1934/01/01','0','Metropolis','USA');
user('Dr','Evil','irule@smallplanet.com','isuckthumbs','1934/01/01','0','Submarine','Under The Sea');
user('Mini','Me','iloveeveil@smallplanet.com','theworld','1934/01/01','0','Submarine','Under Dr Evil');
user('Spider','Man','ispinwebs@newyork.com','MJ','1934/01/01','0','Brooklyn','USA');
user('Dr','Manhattan','idropbombs@manhattan.com','U235','1934/01/01','0','Manhattan','USA');
user('Green','Lantern','iglow@greenmile.com','lantern','1934/01/01','0','wick','lantern');
user('The','Flash','youcannotseeme@lightspeed.com','maythespeedbewithyou','1934/01/01','0','sun','universe');

befriend(1,2);
befriend(2,1);
befriend(1,7);
befriend(7,1);
befriend(1,8);
befriend(8,1);
befriend(2,7);
befriend(7,2);
befriend(2,8);
befriend(8,2);
befriend(3,4);
befriend(4,3);
befriend(5,6);
befriend(6,5);


//=========================================================


function createcircle(){
	$con = connect();
	$circle_name = "UCL colleagues";
	$friend_id = 3;
	$owner_id = 1;
	$query = "INSERT INTO circle(owner_id, circle_name)
			VALUES ('$owner_id','$circle_name');
			INSERT INTO friend_circle(circle_id,friend_id)
			VALUES ((SELECT circle_id FROM circle ORDER BY circle_id DESC LIMIT 1),'$friend_id')";
	$con->query($query) or die ($con->error);
	unset($con);
}


function postgroup(){
	$con = connect();
	$sender_id = 1;
	$post = "Picnic on Sunday!";
	$groups_id = 1;
	$query = "INSERT INTO groupsWallPost(sender_id, post, groups_id)
						VALUES ('$sender_id','$post', '$groups_id')";
	$con->query($query) or die ($con->error);
	unset($con);
}


function addusertogroup(){
	$con = connect();
	$groups_id = 1;
	$user_id = 2;
	$query = "INSERT INTO user_groups(user_id,groups_id)
						VALUES ('$user_id','$groups_id')";
	$con->query($query) or die ($con->error);
	unset($con);
}


function creategroup(){
	$con = connect();
	$user_id = 1;
	$admin_id = $user_id;
	$name = "badminton club";
	$query = "INSERT INTO groups(name)
						VALUES ('$name');
						INSERT INTO user_groups(user_id, groups_id)
						VALUES('$user_id', (SELECT groups_id FROM groups ORDER BY groups_id DESC LIMIT 1));
						INSERT INTO groups_admin(admin_id, groups_id)
						VALUES('$user_id', (SELECT groups_id FROM groups ORDER BY groups_id DESC LIMIT 1))";
	$con->query($query) or die ($con->error);
	unset($con);
}


function postwall(){
	$con = connect();
	$user_id = 1;
	$sender_id = 2;
	$post = "test test";
	$query = "INSERT INTO userWallPost(sender_id, post)
						VALUES ('$sender_id','$post');
						INSERT INTO user_userWallPost(user_id, post_id)
						VALUES('$user_id', (SELECT post_id FROM userWallPost ORDER BY timestamp DESC LIMIT 1))";
	$con->query($query) or die ($con->error);
	unset($con);
}


function befriend($user_id,$friend_id){
	$con = connect();
	// $user_id = $user_id;
	// $friend_id = $friend_id;
	$query = "INSERT INTO user_friend(user_id, friend_id) VALUES ('$user_id','$friend_id')";
	$con->query($query) or die ($con->error);
	unset($con);
}


function clear(){
	$con = connect();
	$query  = "DELETE FROM user; ALTER TABLE user AUTO_INCREMENT = 1";
	$con->query($query) or die ($con->error);;
	unset($con);
}


function user($first_name,$last_name,$email,$password,$date_of_birth,$gender,$city,$country){
	$con = connect();
		// Adding user
	// $first_name=first;
	$middle_name="";
	// $last_name=last;
	// $email=email;
	// $password=pass;
	// $date_of_birth=dob;
	// $gender=gender;
	// $city=city;
	// $country=country;
	// $profile_picture='';
	// $profile_visibility='';
	// $chat_visibility='';

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
	unset($con);
}


function connect(){
	require_once __DIR__ . '/db_config.php';
	$dsn = DSN;
	$user = DB_USER;
	$password = DB_PASSWORD;
	$con = new PDO($dsn, $user, $password);
	if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
	}
	return $con;
}

?>