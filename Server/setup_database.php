<?php

require_once __DIR__ . '/db_config.php';

// Parameters used in creating a new PDO database connection object.
$dsn = DSN;
$user = DB_USER;
$password = DB_PASSWORD;

// Create an instance of the PDO connection to the database.
try {
	$con = new PDO($dsn, $user, $password);
}
catch (PDOException $e) {
	echo("Database connection attempt failed!\n");
	exit();
}

// Remove the current database if it exists.
$sql = "DROP DATABASE IF EXISTS foobook";
$rs = $con->query($sql);
if ($rs === false) {
	trigger_error("Wrong SQL: " . $sql . " Error: " . ($con->error), E_USER_ERROR);
}

// Create a new database.
$sql = "CREATE DATABASE foobook";
$rs = $con->query($sql);
if ($rs === false) {
	trigger_error("Wrong SQL: " . $sql . " Error: " . ($con->error), E_USER_ERROR);
}

// Select the new database.
$sql = "USE foobook";
$rs = $con->query($sql);
if ($rs === false) {
	trigger_error("Wrong SQL: " . $sql . " Error: " . ($con->error), E_USER_ERROR);
}

/* Create each of the tables. */

// USER TABLE
$con->query("CREATE TABLE IF NOT EXISTS user(user_id int unsigned auto_increment not null primary key,
											 first_name varchar(45) not null,
											 middle_name varchar(45),
											 last_name varchar(45) not null,
											 email tinytext not null,
											 password char(60) not null,
											 date_of_birth date not null,
											 gender tinyint(1),
											 city tinytext,
											 country tinytext,
											 profile_picture_id bigint unsigned not null default 1,
											 profile_picture_collection_id bigint unsigned,
											 default_photo_collection_id bigint unsigned,
											 profile_visibility tinyint(1) not null default 0,
											 chat_visibility tinyint(1) not null default 0
											 )
			") or die ($con->error);

//USER_FRIEND
$con->query("CREATE TABLE IF NOT EXISTS user_friend(user_id int unsigned not null references user(user_id),
												    friend_id int unsigned not null references user(user_id),
												    primary key(user_id,friend_id)
												    )
			") or die ($con->error);

//USER_REQUEST
$con->query("CREATE TABLE IF NOT EXISTS user_request(user_id int unsigned not null references user(user_id),
													 request_id int unsigned not null references user(user_id),
													 primary key(user_id,request_id)
													 )
			") or die ($con->error);

//USER_BLOCK
$con->query("CREATE TABLE IF NOT EXISTS user_block(user_id int unsigned not null references user(user_id),
												   block_id int unsigned not null references user(user_id),
												   primary key(user_id,block_id)
												   )
			") or die ($con->error);

//SCHOOL
$con->query("CREATE TABLE IF NOT EXISTS school(school_id int unsigned auto_increment not null primary key,
											   school_name tinytext not null
											   )
			") or die ($con->error);

//USER_SCHOOL
$con->query("CREATE TABLE IF NOT EXISTS user_school(user_id int unsigned not null references user(user_id),
													school_id int unsigned not null references school(school_id),
													start_date date,
													end_date date,
													primary key(user_id,school_id)
													)
			") or die ($con->error);

//EMPLOYER
$con->query("CREATE TABLE IF NOT EXISTS employer(employer_id int unsigned auto_increment not null primary key,
												 employer_name tinytext not null
												 )
			") or die ($con->error);

//USER_EMPLOYER
$con->query("CREATE TABLE IF NOT EXISTS user_employer(user_id int unsigned not null references user(user_id),
													  employer_id int unsigned not null references employer(employer_id),
													  start_date date,
													  end_date date,
													  primary key(user_id,employer_id)
													  )
			") or die ($con->error);

//CIRCLE
$con->query("CREATE TABLE IF NOT EXISTS circle(circle_id bigint unsigned auto_increment not null primary key,
											   owner_id int unsigned not null,
											   foreign key(owner_id) references user(user_id),
											   circle_name tinytext not null
											   )
			") or die ($con->error);

//FRIEND_CIRCLE
$con->query("CREATE TABLE IF NOT EXISTS friend_circle(friend_id int unsigned not null references user(user_id),
													  circle_id bigint unsigned not null references circle(circle_id),
													  primary key(friend_id,circle_id)
													  )
			") or die ($con->error);

//GROUPS
$con->query("CREATE TABLE IF NOT EXISTS groups(groups_id bigint unsigned auto_increment not null primary key,
											   name tinytext not null,
 											   visibility_setting tinyint(1) not null default 0
  											   )
  			") or die ($con->error); 

//GROUPS_ADMIN
$con->query("CREATE TABLE IF NOT EXISTS groups_admin(groups_id bigint unsigned not null references groups(groups_id),
													 admin_id int unsigned not null references user(user_id),
													 primary key(groups_id,admin_id)
													 )
			") or die ($con->error);

//USER_GROUPS
$con->query("CREATE TABLE IF NOT EXISTS user_groups(user_id int unsigned not null references user(user_id),
													groups_id bigint unsigned not null references groups(groups_id),
													primary key(user_id,groups_id)
													)
			") or die ($con->error);

//THREAD
$con->query("CREATE TABLE IF NOT EXISTS thread(thread_id bigint unsigned auto_increment not null primary key,
											   name tinytext
											   )
			") or die ($con->error);

//USER_THREAD
$con->query("CREATE TABLE IF NOT EXISTS user_thread(user_id int unsigned not null references user(user_id),
													thread_id bigint unsigned not null references thread(thread_id),
													primary key(user_id,thread_id)
													)
			") or die ($con->error);

//COLLECTION
$con->query("CREATE TABLE IF NOT EXISTS collection(collection_id bigint unsigned auto_increment not null primary key,
												   user_id int unsigned not null,
												   foreign key(user_id) references user(user_id),
												   name tinytext not null,
												   visibility_setting tinyint(1) not null default 0
												   )
			") or die ($con->error);

//COLLECTION_FRIENDVISIBLITY
$con->query("CREATE TABLE IF NOT EXISTS collection_friendVisibility(collection_id bigint unsigned not null references collection(collection_id),
																	friend_id int unsigned not null references user(user_id),
																	primary key(collection_id,friend_id),
																	visibility_setting tinyint(1) not null default 0
																	)
			") or die ($con->error);

//COLLECTION_CIRCLEVISIBLITY
$con->query("CREATE TABLE IF NOT EXISTS collection_circleVisibility(collection_id bigint unsigned not null references collection(collection_id),
																	circle_id bigint unsigned not null references circle(circle_id),
																	primary key(collection_id,circle_id),
																	visibility_setting tinyint(1) not null default 0
																	)
			") or die ($con->error);

//PHOTO
$con->query("CREATE TABLE IF NOT EXISTS photo(photo_id bigint unsigned auto_increment not null primary key,
											  collection_id bigint unsigned,
											  foreign key(collection_id) references collection(collection_id),
											  photo_content mediumblob not null,
											  description tinytext,
											  visibility_setting tinyint(1) not null default 0
											  )
			") or die ($con->error);

//PHOTO_FRIENDVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS photo_friendVisibility(photo_id bigint unsigned not null,
															   friend_id int unsigned not null,
															   primary key(photo_id,friend_id),
															   visibility_setting tinyint(1) not null default 0
															   )
			") or die ($con->error);

//PHOTO_CIRCLEVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS photo_circleVisibility(photo_id bigint unsigned not null,
															   circle_id bigint unsigned not null,
															   primary key(photo_id,circle_id),
															   visibility_setting tinyint(1) not null default 0
															   )
			") or die ($con->error);

//MESSAGE
$con->query("CREATE TABLE IF NOT EXISTS message(message_id bigint unsigned auto_increment not null primary key,
												sender_id int unsigned not null,
												foreign key(sender_id) references user(user_id),
												userWall_id int unsigned,
												foreign key(userWall_id) references user(user_id),
												groupWall_id bigint unsigned,
												foreign key(groupWall_id) references groups(groups_id),
												thread_id bigint unsigned,
												foreign key(thread_id) references thread(thread_id),
												photo_id bigint unsigned,
												foreign key(photo_id) references photo(photo_id),
												comment_on_post_id bigint unsigned,
												foreign key(comment_on_post_id) references message(message_id),
												message_string text not null,
												timestamp timestamp not null default current_timestamp,
												visibility_setting tinyint(1) not null default 0
												)
			") or die ($con->error);

//MESSAGE_FRIENDVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS message_friendVisibility(message_id bigint unsigned not null references message(message_id),
																 friend_id int unsigned not null references user(user_id),
																 primary key(message_id,friend_id),
																 visibility_setting tinyint(1) not null default 0
																 )
			") or die ($con->error);

//MESSAGE_CIRCLEVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS message_circleVisibility(message_id bigint unsigned not null references message(message_id),
																 circle_id bigint unsigned not null references circle(circle_id),
																 primary key(message_id,circle_id),
																 visibility_setting tinyint(1) not null default 0
																 )
			") or die ($con->error);

// Close the PDO connection to the database.
unset($con);

echo("Database successfully created!\n");

?>