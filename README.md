foobook
=======

GC06 Database Project

=======

19/03/2014 - Tharman, Rodger

	- Drastically altered the structure of the git repo to be deployment-ready.

12/03/2014 - Rodger

	- Moved README.md to outside of the folder for easy access since it is getting too crowded inside the folder, especially App Logic.

10/03/2014 - Rodger

	- TO DO:

		○ Settings:
			-> to update personal info (refer to user table)
			-> to change visibility setting, privacy

		○ Posts:
			-> Able to set visibility settings (individual friend, circles, friends of friends) for user wall posts, collection, groups (open/closed/secret)
			-> update posts
			-> delete posts

		○ Photos:
			-> upload into collection
			-> delete photos
			-> photo message in group
			-> photo message on user wall

		○ Collection page:
			-> create collection
			-> view collection
			-> change visibility setting
			-> delete collection

		○ Friends:
			-> send friend request
			-> create a post of user A and user B are not friends on both user's wall.

		○ Export:
			-> XML format (wth?)

		○ Administrator
			-> able to create an administrator when creating an user
			-> trumps all visibility setting
			-> can manipulate user accounts

		○ Search
			-> able to search school, job, city and country



08/03/2014 - Tharman

List of things to change back before submission:
	- App Logic/homepage.js
		- Remove the Session.set in the 'homepage.js'.

26/02/2014 - Rodger
	
	-In order to allow max upload size of 16M for mediumblob, changes to the php.ini on the server have to be made:
		- Change php.ini upload_max_filesize = 16M
		- Change php.ini post_max_size = 16M

05/02/2014

Testing : This is Rodger making changes again

05/02/2014

Tharman making some change...