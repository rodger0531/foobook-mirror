<?php

//connects server via  
require_once("db_config.php");

//connects the database
require_once("db_connect.php");

// connecting to db
$db = new DB_CONNECT();

// USER TABLE
mysql_query("CREATE TABLE IF NOT EXISTS user(user_id int unsigned auto_increment not null primary key,
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
			") or die (mysql_error());

//FRIEND_CIRCLE
mysql_query("CREATE TABLE IF NOT EXISTS friend_circle(friend_id int unsigned not null,
													  circle_id int unsigned not null,
													  primary key(friend_id,circle_id)
													  )
			") or die (mysql_error());

//CIRCLE
mysql_query("CREATE TABLE IF NOT EXISTS circle(circle_id int unsigned auto_increment not null primary key,
											   circle_name not null tinytext,
											   owner_id int unsigned not null,
											   foreign key (owner_id) references user(user_id)
											   )
			") or die (mysql_error());

//USER_FRIEND
mysql_query("CREATE TABLE IF NOT EXISTS user_friend(user_id int unsigned not null,
												    friend_id int unsigned not null,
												    primary key(user_id,friend_id)
												    )
			") or die (mysql_error());

//USER_REQUEST
mysql_query("CREATE TABLE IF NOT EXISTS user_request(user_id int unsigned not null,
													 request_id int unsigned not null,
													 primary key(user_id,request_id)
													 )
			") or die (mysql_error());

//USER_BLOCK
mysql_query("CREATE TABLE IF NOT EXISTS user_block(user_id int unsigned not null,
												   block_id int unsigned not null,
												   primary key(user_id,block_id)
												   )
			") or die (mysql_error());

//USER_EDUCATION
mysql_query("CREATE TABLE IF NOT EXISTS user_education(user_id int unsigned not null,
													   school_id int unsigned not null,
													   start_date date,
													   end_date date,
													   primary key (user_id, school_id)
													   )
			") or die (mysql_error());

//EDUCATION
mysql_query("CREATE TABLE IF NOT EXISTS education(school_id int unsigned auto_increment not null primary key,
												  school_name tinytext not null
												  )
			") or die (mysql_error());

//USER_EMPLOYER
mysql_query("CREATE TABLE IF NOT EXISTS user_employer(user_id int unsigned not null,
													  employer_id int unsigned not null,
													  start_date date,
													  end_date date,
													  primary key (user_id, employer_id)
													  )
			") or die (mysql_error());

//EMPLOYER
mysql_query("CREATE TABLE IF NOT EXISTS employer(employer_id int unsigned auto_increment not null primary key,
												 employer_name tinytext not null
												 )
			") or die (mysql_error());

//USER_GROUP
mysql_query("CREATE TABLE IF NOT EXISTS user_group(user_id int unsigned not null,
												   group_id bigint unsigned not null,
												   primary key(user_id,group_id)
												   )
			") or die (mysql_error());

//GROUP
mysql_query("CREATE TABLE IF NOT EXISTS group(group_id bigint unsigned auto_increment not null primary key,
											  name tinytext not null,
											  group_visibility tinyint(1) not null default 0
											  )
			") or die (mysql_error());

//GROUP_ADMIN
mysql_query("CREATE TABLE IF NOT EXISTS group_admin(group_id bigint unsigned not null,
												    admin_id int unsigned not null,
												    primary key(group_id,admin_id)
												    )
			") or die (mysql_error());

//GROUPwALLPOST
mysql_query("CREATE TABLE IF NOT EXISTS groupWallPost(post_id bigint unsigned auto_increment not null primary key,
													  group_id bigint unsigned not null foreign key references group(group_id),
													  sender_id int unsigned not null foreign key references user(user_id),
													  post text,
													  timestamp datetime not null default getdate(),
													  visibility_setting tinyint(1) not null default 0
													  )
			") or die (mysql_error());

//GROUPWALLPOST_PHOTO
mysql_query("CREATE TABLE IF NOT EXISTS groupWallPost_photo(post_id bigint unsigned not null,
														    photo_id bigint unsigned not null,
														    primary key(post_id,photo_id)
														    )
			") or die (mysql_error());

//GROUPWALLPOST_COMMENT
mysql_query("CREATE TABLE IF NOT EXISTS groupWallPost_comment(comment_id bigint unsigned auto_increment not null primary key,
															  post_id bigint unsigned not null foreign key references groupWallPost(post_id),
															  sender_id int unsigned not null foreign key references user(user_id),
															  comment text not null,
															  timestamp datetime not null default getdate(),
															  visibility_setting tinyint(1) not null default 0
															  )
			") or die (mysql_error());

//GROUPWALLPOST_FRIENDVISIBILITY
mysql_query("CREATE TABLE IF NOT EXISTS groupWallPost_friendVisibility(post_id bigint unsigned not null,
																	   friend_id int unsigned not null,
																	   primary post_id(key,friend_id)
																	   )
			") or die (mysql_error());

//GROUPWALLPOST_CIRCLEVISIBILITY
mysql_query("CREATE TABLE IF NOT EXISTS groupWallPost_circleVisibility(post_id bigint unsigned not null,
																	   circle_id int unsigned not null,
																	   primary key(post_id,circle_id)
																	   )
			") or die (mysql_error());

//USER_USERWALLPOST
mysql_query("CREATE TABLE IF NOT EXISTS user_userWallPost(user_id int unsigned not null,
														  post_id bigint unsigned not null,
														  primary key(user_id,post_id)
														  )
			") or die (mysql_error());

//USERWALLPOST
mysql_query("CREATE TABLE IF NOT EXISTS userWallPost(post_id bigint unsigned auto_increment not null primary key,
													 sender_id int unsigned not null foreign key references user(user_id),
													 post text,
													 timestamp datetime not null default getdate(),
													 visibility_setting tinyint(1) not null default 0
													 )
			") or die (mysql_error());

//USERWALLPOST_PHOTO
mysql_query("CREATE TABLE IF NOT EXISTS userWallPost_photo(post_id bigint unsigned not null,
														   photo_id bigint unsigned not null,
														   primary key(post_id,photo_id)
														   )
			") or die (mysql_error());

//USERWALLPOST_COMMENT
mysql_query("CREATE TABLE IF NOT EXISTS userWallPost_comment(comment_id bigint unsigned auto_increment not null primary key,
															 post_id bigint unsigned not null foreign key references userWallPost(post_id),
															 sender_id int unsigned not null foreign key references user(user_id),
															 comment text not null,
															 timestamp datetime not null default getdate(),
															 visibility_setting tinyint(1) not null default 0
															 )
			") or die (mysql_error());

//USERWALLPOST_FRIENDVISIBILITY
mysql_query("CREATE TABLE IF NOT EXISTS userWallPost_friendVisibility(post_id bigint unsigned not null,
																	  friend_id int unsigned not null,
																	  primary key (post_id,friend_id)
																	  )
			") or die (mysql_error());

//USERWALLPOST_CIRCLEVISIBILITY
mysql_query("CREATE TABLE IF NOT EXISTS userWallPost_circleVisibility(post_id bigint unsigned not null,
																	  circle_id int unsigned not null,
																	  primary key(post_id,circle_id)
																	  )
			") or die (mysql_error());

//USER_THREAD
mysql_query("CREATE TABLE IF NOT EXISTS user_thread(user_id int unsigned not null,
													thread_id bigint unsigned not null,
													primary key(user_id,thread_id)
													)
			") or die (mysql_error());

//THREAD
mysql_query("CREATE TABLE IF NOT EXISTS thread(thread_id bigint unsigned auto_increment not null primary key,
											   name tinytext
											   )
			") or die (mysql_error());

//THREADMESSAGE
mysql_query("CREATE TABLE IF NOT EXISTS threadMessage(message_id bigint unsigned auto_increment not null primary key,
													  thread_id bigint unsigned not null foreign key references thread(thread_id),
													  sender_id int unsigned not null foreign key references user(user_id),
													  message text,
													  timestamp datetime not null default getdate(),
													  visibility_setting tinyint(1) not null default 0
													  )
			") or die (mysql_error());

//THREADMESSAGE_PHOTO
mysql_query("CREATE TABLE IF NOT EXISTS threadMessage_photo(message_id bigint unsigned not null,
															photo_id bigint unsigned not null,
															primary key(message_id,photo_id)
															)
			") or die (mysql_error());

//PHOTO
mysql_query("CREATE TABLE IF NOT EXISTS photo(photo_id bigint unsigned auto_increment not null primary key,
											  collection_id bigint unsigned not null foreign key references collection(collection_id),
											  name tinytext,
											  photo_visibility tinyint(1) not null default 0,
											  photo mediumblob not null
											  )
			") or die (mysql_error());

//PHOTOCOMMENT
mysql_query("CREATE TABLE IF NOT EXISTS photoComment(comment_id bigint unsigned auto_increment not null primary key,
													 photo_id bigint unsigned not null foreign key references photo(photo_id),
													 sender_id int unsigned not null foreign key references user(user_id),
													 comment text not null,
													 timestamp datetime not null default getdate(),
													 visibility_setting tinyint(1) not null default 0
													 )
			") or die (mysql_error());

//PHOTO_FRIENDVISIBILITY
mysql_query("CREATE TABLE IF NOT EXISTS photo_friendVisibility(photo_id bigint unsigned not null,
															   friend_id int unsigned not null,
															   primary key (photo_id,friend_id)
															   )
			") or die (mysql_error());

//PHOTO_CIRCLEVISIBILITY
mysql_query("CREATE TABLE IF NOT EXISTS photo_circleVisibility(photo_id bigint unsigned not null,
															   circle_id int unsigned not null,
															   primary key(photo_id,circle_id)
															   )
			") or die (mysql_error());

//COLLECTION
mysql_query("CREATE TABLE IF NOT EXISTS collection(collection_id bigint unsigned auto_increment not null primary key,
												   user_id int unsigned not null foreign key references user(user_id),
												   name tinytext not null
												   )
			") or die (mysql_error());

//COLLECTION_FRIENDVISIBLITY
mysql_query("CREATE TABLE IF NOT EXISTS collection_friendVisibility(collection_id bigint unsigned not null,
																	friend_id int unsigned not null,
																	primary key (collection_id,friend_id)
																	)
			") or die (mysql_error());

//COLLECTION_CIRCLEVISIBLITY
mysql_query("CREATE TABLE IF NOT EXISTS collection_circleVisibility(collection_id bigint unsigned not null,
																	circle_id int unsigned not null,
																	primary key(collection_id,circle_id)
																	)
			") or die (mysql_error());

?>