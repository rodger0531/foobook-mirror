<?php

include 'setup_database.php';

//user($first_name,$last_name,$email,$password,$date_of_birth,$gender,$city,$country)
user('Bat','Man','alfred@batmansion.com','robin','1934/01/01','0','Gotham city','USA');
user('Super','Man','imnothere@krypton.com','kryptonite','1934/01/01','0','Metropolis','USA');
user('Dr','Evil','irule@smallplanet.com','isuckthumbs','1934/01/01','0','Submarine','Under The Sea');
user('Mini','Me','iloveeveil@smallplanet.com','theworld','1934/01/01','0','Submarine','Under Dr Evil');
user('Spider','Man','ispinwebs@newyork.com','MJ','1934/01/01','0','Brooklyn','USA');
user('Dr','Manhattan','idropbombs@manhattan.com','U-235','1934/01/01','0','Manhattan','USA');
user('Green','Lantern','iglow@greenmile.com','lantern','1934/01/01','0','wick','lantern');
user('The','Flash','youcannotseeme@lightspeed.com','maythespeedbewithyou','1934/01/01','0','sun','universe');

//befriend($user_id,$friend_id)
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

//postwall($sender_id,$userWall_id,$message_string){
postwall(1,1,"I am a Bat(scat)man!");

//creategroup($user_id,$admin_id,$name)
creategroup(3,3,"Project Apocalypse");
creategroup(2,2,"How to save the world");

//addusertogroup($user_id,$groups_id)
addusertogroup(4,1);
addusertogroup(6,1);
addusertogroup(1,2);
addusertogroup(8,2);
addusertogroup(5,2);

//postgroup($sender_id,$groupWall_id,$message_string)
postgroup(2,2,"Picnic tomorrow on top of Eiffel Tower");
postgroup(8,2,"I have to get new shoes");
postgroup(7,2,"My batteries need replacing");
postgroup(3,1,"Destruction 101");
postgroup(6,1,"Anyone know where I can find U-237?");

// createcircle($owner_id,$circle_name)
createcircle(1,"saving-the-world buddies");

//addfriendtocircle($circle_id,$friend_id)
addfriendtocircle(1,2);
addfriendtocircle(1,5);
addfriendtocircle(1,7);
addfriendtocircle(1,8);

echo ("Done! \n");
//=========================================================

function addfriendtocircle($circle_id,$friend_id){
	$con = connect();
	$query = "INSERT INTO friend_circle(circle_id,friend_id)
			  VALUES ($circle_id,'$friend_id')";
	$con->query($query) or die ($con->error);
	unset($con);
}

function createcircle($owner_id,$circle_name){
	$con = connect();
	$query = "INSERT INTO circle(owner_id, circle_name)
			  VALUES ('$owner_id','$circle_name')";			
	$con->query($query) or die ($con->error);
	unset($con);
}

function postgroup($sender_id,$groupWall_id,$message_string){
	$con = connect();
	$query = "INSERT INTO message(sender_id, groupWall_id, message_string)
			  VALUES ('$sender_id','$groupWall_id','$message_string')";
	$con->query($query) or die ($con->error);
	unset($con);
}


function addusertogroup($user_id,$groups_id){
	$con = connect();
	$query = "INSERT INTO user_groups(user_id,groups_id)
			  VALUES ('$user_id','$groups_id')";
	$con->query($query) or die ($con->error);
	unset($con);
}


function creategroup($user_id,$admin_id,$name){
	$con = connect();
	$query = "INSERT INTO groups(name)
			  VALUES ('$name');
			  INSERT INTO user_groups(user_id, groups_id)
			  VALUES('$user_id', (SELECT groups_id FROM groups ORDER BY groups_id DESC LIMIT 1));
			  INSERT INTO groups_admin(admin_id, groups_id)
  			  VALUES('$user_id', (SELECT groups_id FROM groups ORDER BY groups_id DESC LIMIT 1))";
	$con->query($query) or die ($con->error);
	unset($con);
}


function postwall($sender_id,$userWall_id,$message_string){
	$con = connect();
	$query = "INSERT INTO message(sender_id,userWall_id,message_string)
				VALUES ('$sender_id','$userWall_id','$message_string')";
	$con->query($query) or die ($con->error);
	unset($con);
}


function befriend($user_id,$friend_id){
	$con = connect();
	$query = "INSERT INTO user_friend(user_id, friend_id)
			  VALUES ('$user_id','$friend_id')";
	$con->query($query) or die ($con->error);
	unset($con);
}


function user($first_name,$last_name,$email,$password,$date_of_birth,$gender,$city,$country){
	$con = connect();
	$middle_name="";
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