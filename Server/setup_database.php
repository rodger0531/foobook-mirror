<?php

define('DB_USER', 'root'); // db user
define('DB_PASSWORD', ''); // db password
define('DB_DATABASE', 'foobook'); // database name
define('DB_SERVER', 'localhost'); // db server

// create mysqli object
$con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

// remove current database
$sql = 'DROP DATABASE IF EXISTS foobook';
$rs = $con->query($sql);
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . ($con->error), E_USER_ERROR);
}

// create a new database
$sql='CREATE DATABASE foobook';
$rs = $con->query($sql);
if($rs === false) {
  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . ($con->error), E_USER_ERROR);
}

// select database
$con->select_db(DB_DATABASE);

// USER TABLE
$con->query("CREATE TABLE IF NOT EXISTS user(user_id int unsigned auto_increment not null primary key,
											 first_name varchar(45) not null,
											 middle_name varchar(45),
											 last_name varchar(45) not null,
											 email tinytext not null,
											 password varchar(32) not null,
											 date_of_birth date not null,
											 gender tinyint(1),
											 city tinytext,
											 country tinytext,
											 profile_picture bigint unsigned not null default 0,
											 profile_visibility tinyint(1) not null default 0,
											 chat_visibility tinyint(1) not null default 0
											 )
			") or die ($con->error);

//FRIEND_CIRCLE
$con->query("CREATE TABLE IF NOT EXISTS friend_circle(friend_id int unsigned not null,
													  circle_id int unsigned not null,
													  primary key(friend_id,circle_id)
													  )
			") or die ($con->error);

//CIRCLE
$con->query("CREATE TABLE IF NOT EXISTS circle(circle_id int unsigned auto_increment not null primary key,
											   circle_name tinytext not null,
											   owner_id int unsigned not null,
											   foreign key(owner_id) references user(user_id)
											   )
			") or die ($con->error);

//USER_FRIEND
$con->query("CREATE TABLE IF NOT EXISTS user_friend(user_id int unsigned not null,
												    friend_id int unsigned not null,
												    primary key(user_id,friend_id)
												    )
			") or die ($con->error);

//USER_REQUEST
$con->query("CREATE TABLE IF NOT EXISTS user_request(user_id int unsigned not null,
													 request_id int unsigned not null,
													 primary key(user_id,request_id)
													 )
			") or die ($con->error);

//USER_BLOCK
$con->query("CREATE TABLE IF NOT EXISTS user_block(user_id int unsigned not null,
												   block_id int unsigned not null,
												   primary key(user_id,block_id)
												   )
			") or die ($con->error);

//USER_EDUCATION
$con->query("CREATE TABLE IF NOT EXISTS user_education(user_id int unsigned not null,
													   school_id int unsigned not null,
													   start_date date,
													   end_date date,
													   primary key(user_id,school_id)
													   )
			") or die ($con->error);

//EDUCATION
$con->query("CREATE TABLE IF NOT EXISTS education(school_id int unsigned auto_increment not null primary key,
												  school_name tinytext not null
												  )
			") or die ($con->error);

//USER_EMPLOYER
$con->query("CREATE TABLE IF NOT EXISTS user_employer(user_id int unsigned not null,
													  employer_id int unsigned not null,
													  start_date date,
													  end_date date,
													  primary key(user_id,employer_id)
													  )
			") or die ($con->error);

//EMPLOYER
$con->query("CREATE TABLE IF NOT EXISTS employer(employer_id int unsigned auto_increment not null primary key,
												 employer_name tinytext not null
												 )
			") or die ($con->error);

//USER_groups
$con->query("CREATE TABLE IF NOT EXISTS user_groups(user_id int unsigned not null,
												   groups_id bigint unsigned not null,
												   primary key(user_id,groups_id)
												   )
			") or die ($con->error);

//groups
$con->query("CREATE TABLE IF NOT EXISTS groups(groups_id bigint unsigned auto_increment not null primary key,
											  name tinytext not null,
											  groups_visibility tinyint(1) not null default 0
											  )
			") or die ($con->error);

//groups_ADMIN
$con->query("CREATE TABLE IF NOT EXISTS groups_admin(groups_id bigint unsigned not null,
												    admin_id int unsigned not null,
												    primary key(groups_id,admin_id)
												    )
			") or die ($con->error);

//groupswALLPOST
$con->query("CREATE TABLE IF NOT EXISTS groupsWallPost(post_id bigint unsigned auto_increment not null primary key,
													  groups_id bigint unsigned not null,
													  foreign key(groups_id) references groups(groups_id),
													  sender_id int unsigned not null,
													  foreign key(sender_id) references user(user_id),
													  post text,
													  timestamp timestamp default current_timestamp,
													  visibility_setting tinyint(1) not null default 0
													  )
			") or die ($con->error);

//groupsWALLPOST_PHOTO
$con->query("CREATE TABLE IF NOT EXISTS groupsWallPost_photo(post_id bigint unsigned not null,
														    photo_id bigint unsigned not null,
														    primary key(post_id,photo_id)
														    )
			") or die ($con->error);

//groupsWALLPOST_COMMENT
$con->query("CREATE TABLE IF NOT EXISTS groupsWallPost_comment(comment_id bigint unsigned auto_increment not null primary key,
															  post_id bigint unsigned not null,
															  foreign key(post_id) references groupsWallPost(post_id),
															  sender_id int unsigned not null,
															  foreign key(sender_id) references user(user_id),
															  comment text not null,
															  timestamp timestamp default current_timestamp,
															  visibility_setting tinyint(1) not null default 0
															  )
			") or die ($con->error);

//groupsWALLPOST_FRIENDVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS groupsWallPost_friendVisibility(post_id bigint unsigned not null,
																	   friend_id int unsigned not null,
																	   primary key(post_id,friend_id)
																	   )
			") or die ($con->error);

//groupsWALLPOST_CIRCLEVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS groupsWallPost_circleVisibility(post_id bigint unsigned not null,
																	   circle_id int unsigned not null,
																	   primary key(post_id,circle_id)
																	   )
			") or die ($con->error);

//USER_USERWALLPOST
$con->query("CREATE TABLE IF NOT EXISTS user_userWallPost(user_id int unsigned not null,
														  post_id bigint unsigned not null,
														  primary key(user_id,post_id)
														  )
			") or die ($con->error);

//USERWALLPOST
$con->query("CREATE TABLE IF NOT EXISTS userWallPost(post_id bigint unsigned auto_increment not null primary key,
													 sender_id int unsigned not null,
													 foreign key(sender_id) references user(user_id),
													 post text,
													 timestamp timestamp default current_timestamp,
													 visibility_setting tinyint(1) not null default 0
													 )
			") or die ($con->error);

//USERWALLPOST_PHOTO
$con->query("CREATE TABLE IF NOT EXISTS userWallPost_photo(post_id bigint unsigned not null,
														   photo_id bigint unsigned not null,
														   primary key(post_id,photo_id)
														   )
			") or die ($con->error);

//USERWALLPOST_COMMENT
$con->query("CREATE TABLE IF NOT EXISTS userWallPost_comment(comment_id bigint unsigned auto_increment not null primary key,
															 post_id bigint unsigned not null,
															 foreign key(post_id) references userWallPost(post_id),
															 sender_id int unsigned not null,
															 foreign key(sender_id) references user(user_id),
															 comment text not null,
															 timestamp timestamp default current_timestamp,
															 visibility_setting tinyint(1) not null default 0
															 )
			") or die ($con->error);

//USERWALLPOST_FRIENDVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS userWallPost_friendVisibility(post_id bigint unsigned not null,
																	  friend_id int unsigned not null,
																	  primary key(post_id,friend_id)
																	  )
			") or die ($con->error);

//USERWALLPOST_CIRCLEVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS userWallPost_circleVisibility(post_id bigint unsigned not null,
																	  circle_id int unsigned not null,
																	  primary key(post_id,circle_id)
																	  )
			") or die ($con->error);

//USER_THREAD
$con->query("CREATE TABLE IF NOT EXISTS user_thread(user_id int unsigned not null,
													thread_id bigint unsigned not null,
													primary key(user_id,thread_id)
													)
			") or die ($con->error);

//THREAD
$con->query("CREATE TABLE IF NOT EXISTS thread(thread_id bigint unsigned auto_increment not null primary key,
											   name tinytext
											   )
			") or die ($con->error);

//THREADMESSAGE
$con->query("CREATE TABLE IF NOT EXISTS threadMessage(message_id bigint unsigned auto_increment not null primary key,
													  thread_id bigint unsigned not null,
													  foreign key(thread_id) references thread(thread_id),
													  sender_id int unsigned not null,
													  foreign key(sender_id) references user(user_id),
													  message text,
													  timestamp timestamp default current_timestamp,
													  visibility_setting tinyint(1) not null default 0
													  )
			") or die ($con->error);

//THREADMESSAGE_PHOTO
$con->query("CREATE TABLE IF NOT EXISTS threadMessage_photo(message_id bigint unsigned not null,
															photo_id bigint unsigned not null,
															primary key(message_id,photo_id)
															)
			") or die ($con->error);


//COLLECTION
$con->query("CREATE TABLE IF NOT EXISTS collection(collection_id bigint unsigned auto_increment not null primary key,
												   user_id int unsigned not null,
												   foreign key(user_id) references user(user_id),
												   name tinytext not null
												   )
			") or die ($con->error);

//PHOTO
$con->query("CREATE TABLE IF NOT EXISTS photo(photo_id bigint unsigned auto_increment not null primary key,
											  collection_id bigint unsigned not null,
											  foreign key(collection_id) references collection(collection_id),
											  name tinytext,
											  photo_visibility tinyint(1) not null default 0,
											  photo mediumblob not null
											  )
			") or die ($con->error);

//PHOTOCOMMENT
$con->query("CREATE TABLE IF NOT EXISTS photoComment(comment_id bigint unsigned auto_increment not null primary key,
													 photo_id bigint unsigned not null,
													 foreign key(photo_id) references photo(photo_id),
													 sender_id int unsigned not null,
													 foreign key(sender_id) references user(user_id),
													 comment text not null,
													 timestamp timestamp default current_timestamp,
													 visibility_setting tinyint(1) not null default 0
													 )
			") or die ($con->error);

//PHOTO_FRIENDVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS photo_friendVisibility(photo_id bigint unsigned not null,
															   friend_id int unsigned not null,
															   primary key(photo_id,friend_id)
															   )
			") or die ($con->error);

//PHOTO_CIRCLEVISIBILITY
$con->query("CREATE TABLE IF NOT EXISTS photo_circleVisibility(photo_id bigint unsigned not null,
															   circle_id int unsigned not null,
															   primary key(photo_id,circle_id)
															   )
			") or die ($con->error);


//COLLECTION_FRIENDVISIBLITY
$con->query("CREATE TABLE IF NOT EXISTS collection_friendVisibility(collection_id bigint unsigned not null,
																	friend_id int unsigned not null,
																	primary key(collection_id,friend_id)
																	)
			") or die ($con->error);

//COLLECTION_CIRCLEVISIBLITY
$con->query("CREATE TABLE IF NOT EXISTS collection_circleVisibility(collection_id bigint unsigned not null,
																	circle_id int unsigned not null,
																	primary key(collection_id,circle_id)
																	)
			") or die ($con->error);

$con->close();

?>