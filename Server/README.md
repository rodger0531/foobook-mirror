This README file contains information about all changes relating to the 'Server' folder. 

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
				- revision Rodger (08/02/2014) - typos
				- revision Tharman (08/02/2014) - typo in filename, 'cirlce.php' -> 'circle.php'
		- collection - done Philip (07/02/2014)
		- collection_circleVisibility - done Philip (07/02/2014) - REVISION NEEDED!!!
		- collection_friendVisibility - done Philip (07/02/2014) - REVISION NEEDED!!!
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

08/02/2014 - Rodger

	- Altered the setup database php file from mysql to mysqli. I adopted object oriented style instead of procedural style it was before. This allows high security due to it being prepared statement and prevents hacking such as injection.
	- Combined db_config and db_connect into the file so it does not need the variables and classes to run, i.e. it is a standalone version.
	- Updated circle.php -> typos
	- NOTE: we need to change php files to object orientated mysqli method.

08/02/2014 - Tharman

	- Addressed Philip's concerns regarding the system in 'CRUD_php_Problems.txt'.
	- Made a few alterations to the 'setup_database.php' file:
		- Grouped 'collection' related parts together.
		- Changed 'groups_visibility' attribute in 'groups' and 'photo_visiblity' in the 'photo' table to 'visibility_setting' - consistency.
		- Added 'visiblity_setting' attribute to the 'collection' table. We had the friend and circle visilbity tables, but why not this field then? I assumed it was a mistake, and have added it.
		- Added 'visiblity_setting' attribute to all of the 'circleVisiblity' and 'friendVisiblity' tables. Good catch by Philip.
		- Removed 'visiblity_setting' attribute from 'threadMessage' table. Why was that there? Users aren't supposed to be able to assign visibility to a thread message, right?
		- 'visiblity_setting' attributes should be correct across the board now.

10/02/2014 - Rodger
	
	-Re-added "visibility_setting tinyint(1) not null default 0" to those tables which got accidentally removed.