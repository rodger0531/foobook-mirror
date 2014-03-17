<?php

include 'setup_database.php';

//user($first_name,$last_name,$email,$password,$date_of_birth,$gender,$city,$country)
user('Bat','Man','bat@man.com','robin','1934/01/01','0','Gotham city','USA');
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
postwall(1,2,"I have Kryptonite!!!");

//creategroup($user_id,$admin_id,$groups_name)
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

postwall(1,8,"Why can''t I be as fast as you...?");
postwall(8,1,"I can run circles around you! :)");

// createcircle($owner_id,$circle_name)
createcircle(1,"saving-the-world buddies");

//addfriendtocircle($circle_id,$friend_id)
addfriendtocircle(1,2);
addfriendtocircle(1,5);
addfriendtocircle(1,7);
addfriendtocircle(1,8);

// sendmessage($sender_id,$participantsList,$message_string,$chat_name)
// NOTE: $name will be ignored if there is an existing thread
//       $participantsList is an array list.
$participantsList = array(1,3,5);
sendmessage(2,$participantsList,'I saw you and batwomen yesterday, you might want to use thicker walls. #X-rayVision','Gossip');
$participantsList = array(2,3,5);
sendmessage(1,$participantsList,'Oh no!','NULL');
$participantsList = array(1,2,5);
sendmessage(3,$participantsList,'Hahaha','NULL');
$participantsList = array(1,3,2);
sendmessage(5,$participantsList,"Where''s the video??",'NULL');

$participantsList = array(4);
sendmessage(1,$participantsList,'Hey how are you sexy?','SexyBeast');

echo ("Test data inserted!\n");
//=========================================================

function sendmessage($sender_id,$participantsList,$message_string,$chat_name){
	$con = connect();
	// initialise array with sender_id
	$participants=$sender_id;

	// loops through to concatenate participant ids into array for SQL query statement
	foreach ($participantsList as $element) {
		$participants = $participants .",". $element;
	}
	// get size of participant array
	$threadSize = count($participantsList)+1;

	// checks if a conversation thread exists
	$querycheck = "SELECT DISTINCT thread_id
				   FROM user_thread
				   WHERE user_id IN ($participants) AND thread_id NOT IN
				   (
				   SELECT DISTINCT thread_id
				   FROM user_thread
				   WHERE user_id NOT IN ($participants)
				   )
				   GROUP BY thread_id
				   HAVING COUNT(user_id) = $threadSize";
	
	// execute sql to check for if a thread exists
	$stmt = $con->prepare($querycheck);
	$stmt->execute();
	$result= $stmt->fetch();

	// if no result from fetch -> create a new thread, if not -> insert into existing thread
	if (!$result){
		// creates a new conversation thread_id
		$querycreate = "INSERT INTO thread(thread_name) VALUES ('$chat_name');";
		// concatenates each id
		$querycreate = $querycreate . "INSERT INTO user_thread(user_id,thread_id) VALUES ($sender_id,LAST_INSERT_ID());";
		foreach ($participantsList as $chat_id) {
			$querycreate = $querycreate . "INSERT INTO user_thread(user_id,thread_id) VALUES ($chat_id,LAST_INSERT_ID());";
		}
		// concatenates sender_id
		$querycreate = $querycreate . "INSERT INTO message(sender_id,thread_id,message_string) VALUES ($sender_id,LAST_INSERT_ID(),'$message_string')";
		// echo $querycreate;
		$stmt = $con->prepare($querycreate);
	} else {
		$existing_thread = $result['thread_id'];
		// continues a thread
		$querycurrent = "INSERT INTO message(sender_id,thread_id,message_string) VALUES ('$sender_id','$existing_thread','$message_string')";
		$stmt = $con->prepare($querycurrent);
	}
	
	$stmt->execute();
	unset($con);
}


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


function creategroup($user_id,$admin_id,$groups_name){
	$con = connect();
	$query = "INSERT INTO groups(groups_name)
			  VALUES ('$groups_name');
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