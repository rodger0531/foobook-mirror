This README file contains information about the Server folder all the realted changes. 

	NOTE: PLEASE CREATE A NEW ENTRY EVERYTIME YOU COMMIT A CHANGE TO THIS FOLDER.

05.02.2014 - Philip

	- I have moved the files we have created from Dropbox to GitHub. The file names are as follows:
		-db_config.php
		-db_connect.php
		-example_create_user.php
		-setup_database.php

06/02/2014 - Philip and Tharman

	- Corrected the keyword order in the 'setup_database.php' file.
	- Tested out on phpMyAdmin with the following issues:
		- Doesn't allow the name 'group' for that table;
		- Doesn't allow us to use getDate() for the default value of the timestamps.

06/02/2014 - Rodger

	-Changed all keyword "group" to "groups" since group is a reserved keyword in MySQL.
	-Changed timestamp data type from DATETIME to TIMESTAMP. reason: DATETIME does not allow default CURRENT_TIMESTAMP.
	-Script works as of this version change via php setup_database.php in terminal.
	-Created a php script to update user table (create user) via JSON/AJAX

07/02/2014 - Rodger
	
	-Added AJAX test script (test.js and test.html)

07/02/2014 - Philip and Tharman

	-Generated the first CRUD php file, the "user" one. We tested it and it works, so it can serve as a future reference file for the rest of the tables.
	-The Deletion part is ambiguous at this point (we still need to figure that part out), but we agreed on including the Deletion part everywhere and change it later.
	-Here is the list of all the tables we need to create CRUD php files for:

		- cicle - done Philip (07/02/2014) - REVISION NEEDED!!!
		- collection - done Philip (07/02/2014)
		- collection_circleVisibility - done Philip (07/02/2014) - REVISION NEEDED!!!
		- collection_friendVisibility
		- education
		- employer
		- friend_circle
		- groups
		- groupsWallPost
		- groupsWallPost_circleVisibility
		- groupWallPost_comment
		- groupWallPost_friendVisibility
		- groupWallPost_photo
		- group_admin
		- photo
		- photoComment
		- photo_circleVisibility
		- photo_friendVisibility
		- thread
		- threadMessage
		- threadMessage_photo
		- user - done Philip, Tharman and Rodger (07/02/2014)
		- userWallPost
		- userWallPost_circleVisibility
		- userWillPost_comment
		- userWallPost_friendVisibility
		- userWallPost_photo
		- user_block
		- user_education
		- user_employer
		- user_friend
		- user_groups
		- user_request
		- user_thread
		- user_userWallPost
