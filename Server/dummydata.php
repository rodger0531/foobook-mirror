<?php

//=========================================================
//////////////////////INSTRUCTIONS/////////////////////////
/*
Cases:
1 - reset database
2 - clear user table and reset user_id auto-increment
3 - create user
4 - befriend two users
5 - post on wall
6 - create group
7 - add user to group
8 - post on group wall
9 - create a circle
*/

/*
Combos:
1 - clean database
		create 2 users
		befriend them
		create a group
		add all users into group
		post a message onto user 1's wall
		user 1 posts message onto group wall
*/

//=========================================================
/////////////////////////EXECUTION/////////////////////////

queryswitch(9);
// comboswitch(1);


//=========================================================

function comboswitch($switch_case){
	switch($switch_case){
		case 1:
			queryswitch(1);
			queryswitch(3);
			queryswitch(3);
			queryswitch(4);
			queryswitch(5);
			queryswitch(6);
			queryswitch(7);
			queryswitch(8);
			break;
	}
}


function queryswitch($switch_case){
	switch($switch_case){
		case 1:
			include 'setup_database.php';
			break;

		case 2:
			clear();		
			break;

		case 3:
			user();
			break;

		case 4:
			befriend();
			break;

		case 5:
			postwall();
			break;

		case 6:
			creategroup();
			break;

		case 7:
			addusertogroup();
			break;

		case 8:
			postgroup();
			break;

		case 9:
			createcircle();
			break;
	}
}

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


function befriend(){
	$con = connect();
	$user_id = 1;
	$friend_id = 2;
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


function user(){
	$con = connect();
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