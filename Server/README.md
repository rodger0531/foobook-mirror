This README file contains information about all changes relating to the 'Server' folder. 

	NOTE: PLEASE CREATE A NEW ENTRY EVERYTIME YOU COMMIT A CHANGE TO THIS FOLDER.
=========================================================================================

14/02/2014 - Rodger

	- Added the ability to create circles and friends into circles to dummydata.php

13/02/2014 - Philip and Abdi
	
	- Add comments to case switch at the bottom of circle.php. 
	- Finished and tested "collection.php", it is working perfectly.

13/02/2014 - Philip 

	- Tested "circle.php" it is working perfectly.

13/02/2014 - Rodger

	- Updated dummydata.php -> it can now create user, group; befriend users; post messages on user and group walls; insert user into group.
	- Also includes a combo function =)

12/02/2014 - Tharman

	- Separated out the AJAX function, and it can now return JSON data by running a passed in callback function from its success function.
	- Also created a 'controller.js' file which will be included client-side (as per usual), and defines event actions to be performed.
	- The tests should be run from the controller file now, since the 'ajax' function is final, and independent now.

12/02/2014 - Tharman

	- Removed the 'test' folder since it is no longer needed.
	- Made minor fixes to 'setup_database.php' and 'ajax.js'.
	- Removed old testing section from 'user.php'.
	- Re-posting CRUD files list, to be implemented. Check off as completed.
	
		- circle																- Tharman (12/02/2014) - Finished 13/02/2014. Tested (Philip)
		- collection 														- Philip (13/02/2014) - Finished 13/02/2014. Tested (Philip)
		- collection_circleVisibility 					- Philip (13/02/2014) - Finished 14/02/2014. Tested (Philip)
		- collection_friendVisibility 					- Philip (13/02/2014) - Finished 14/02/2014. Tested (Philip) 
		- education 														- Philip (13/02/2014) - Working on it! 
		- employer 															- Philip (13/02/2014) - Working on it! 
		- friend_circle 												- Tharman (13/02/2014) - Working on.
		- groups 																- Tharman (13/02/2014) - Working on.
		- groupsWallPost 												- Tharman (13/02/2014) - Working on.
		- groupsWallPost_circleVisibility			 	- Tharman (13/02/2014) - Working on.
		- groupWallPostComment 									- Tharman (13/02/2014) - Working on.
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
		- user 																	- Philip, Tharman and Rodger (11/02/2014). Finished 12/02/2014. Tested.
		- userWallPost
		- userWallPost_circleVisibility
		- userWillPostComment
		- userWallPost_friendVisibility
		- userWallPost_photo
		- user_block														- Rodger (14/02/2014) - Working on.
		- user_education
		- user_employer
		- user_friend
		- user_groups
		- user_request
		- user_thread
		- user_userWallPost

12/02/2014 - Rodger

	-Fixed: Read function in user.php: Ajax is returning response as an array now. The object querried from PDO was not successfully called. $result was used instead of $this->result.
	-Have tested out read function and works as of now 2:37pm.

12/02/2014 - Tharman

	- Cleaned up code pretty extensively.
	- Implemented the switch mechanism.
	- Fixed the 'setup_database.php' file - was broken previously because it was still using MySQLi, not PDO.
	- Added a few test cases to the 'ajax.php' file.
	- TODO: The ajax is not properly passing out the PHP array being returned from the read function.

11/02/2014 - Tharman, Philip, Rodger

	- Optimised the 'Server' folder.
	- Finished the 'db_connect.php' and 'user.php' files.
	- Added Test folder with relevant test files for ajax (array fetching from front-end side)

11/02/2014 - Tharman

	- Added a .gitignore file to the PDO folder to ensure that config.php is not committed.
	- Successfully created the create() method.
	- TODO: Need to revise the OO structure.

11/02/2014 - Rodger

	- Created a file "dummydata.php" for easy insertion of fake information for testing purposes, can be extended to insert into other tables.
	- Altered the password in "db_config.php" in the "PDO files" folder as it contained someone's password

10/02/2014 - Philip, Rodger, Tharman
	
	- Successfully created a working Read abstracted file. To be continued ....................... :) NOTE: Still have to fix AJAX returning array. 

10/02/2014 - Rodger
	
	- Re-added "visibility_setting tinyint(1) not null default 0" to those tables which got accidentally removed.

08/02/2014 - Tharman

	- Addressed Philip's concerns regarding the system in 'CRUD_php_Problems.txt'.
	- Made a few alterations to the 'setup_database.php' file:
		- Grouped 'collection' related parts together.
		- Changed 'groups_visibility' attribute in 'groups' and 'photo_visiblity' in the 'photo' table to 'visibility_setting' - consistency.
		- Added 'visiblity_setting' attribute to the 'collection' table. We had the friend and circle visilbity tables, but why not this field then? I assumed it was a mistake, and have added it.
		- Added 'visiblity_setting' attribute to all of the 'circleVisiblity' and 'friendVisiblity' tables. Good catch by Philip.
		- Removed 'visiblity_setting' attribute from 'threadMessage' table. Why was that there? Users aren't supposed to be able to assign visibility to a thread message, right?
		- 'visiblity_setting' attributes should be correct across the board now.

08/02/2014 - Rodger

	- Altered the setup database php file from mysql to mysqli. I adopted object oriented style instead of procedural style it was before. This allows high security due to it being prepared statement and prevents hacking such as injection.
	- Combined db_config and db_connect into the file so it does not need the variables and classes to run, i.e. it is a standalone version.
	- Updated circle.php -> typos
	- NOTE: we need to change php files to object orientated mysqli method.

07/02/2014 - Philip and Tharman

	-Generated the first CRUD php file, the "user" one. We tested it and it works, so it can serve as a future reference file for the rest of the tables.
	-The Deletion part is ambiguous at this point (we still need to figure that part out), but we agreed on including the Deletion part everywhere and change it later.
	-Here is the list of all the tables we need to create CRUD php files for:

		- circle - done Philip (07/02/2014) - REVISION NEEDED!!!
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

07/02/2014 - Rodger
	
	-Added AJAX test script (test.js and test.html)

06/02/2014 - Rodger

	-Changed all keyword "group" to "groups" since group is a reserved keyword in MySQL.
	-Changed timestamp data type from DATETIME to TIMESTAMP. reason: DATETIME does not allow default CURRENT_TIMESTAMP.
	-Script works as of this version change via php setup_database.php in terminal.
	-Created a php script to update user table (create user) via JSON/AJAX

06/02/2014 - Philip and Tharman

	- Corrected the keyword order in the 'setup_database.php' file.
	- Tested out on phpMyAdmin with the following issues:
		- Doesn't allow the name 'group' for that table;
		- Doesn't allow us to use getDate() for the default value of the timestamps.

05.02.2014 - Philip

	- I have moved the files we have created from Dropbox to GitHub. The file names are as follows:
		-db_config.php
		-db_connect.php
		-example_create_user.php
		-setup_database.php
