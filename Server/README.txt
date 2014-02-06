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

07/02/2014 - Rodger

	-Changed all keyword "group" to "groups" since group is a reserved keyword in MySQL