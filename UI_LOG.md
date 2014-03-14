This log file contains information about all changes relating to the 'UI' folder. 

	NOTE: PLEASE CREATE A NEW ENTRY EVERYTIME YOU COMMIT A CHANGE TO THIS FOLDER.
=======================================================================================

14/03/2014 - Tharman

	- Updated the newsFeed css file.
	- Now generates the newsfeed (minus comments) in a really nice way.

	- Updated the wallPost css file.
	- Now has constant background of white, so we can change the background of the page later without damaging anything else.

13/03/2014 - Tharman

	- Added the completed newsfeed css file.
	- Works correctly, but without commenting.

	- Added a version of the homepage html, which has an empty newsfeed div.
	- Will be dynamically populated.

12/03/2014 - Rodger

	- Added circle.html for the basic structure for circles.

12/03/2014 - Tharman

	- Adding homepage html, and wall post and newsfeed css files.
	- Not finished yet.

08/03/2014 - Tharman

	- Updated 'homepage.js' to include an overall controller js file.

06/03/2014 - Abdi 

	- Updated 'allResults.html' to include the neccessary css files 

06/03/2014 - Philip

	- Added the message.html and the supporting CSS and JS files.
	- We have multiple scrollable options.
	- The actual message boxes are depending on the inputed text. So they resize.

05/03/2014 - Philip

	- Added the profile.html page and the supporting CSS and JS files.
	- This is only a sceleton so we can start matching the database with the UI.

04/03/2014 - Tharman

	- Manually merged my changes, Abdi and Philip's into a single 'homepage.html' file.
	- Now includes posting to the wall.

03/03/2014 - Rodger

	- Added friendBlock.html
		- Allows user to block a friend, remove a friend from blocked list, and view all the user's blocked friend list

03/03/2014 - Abdi and Philip

	- Updated newsfeed.html to include:
	 	- search.js in order to search for users and groups from the database
	 	- session.js in order to store user_id in a session
	 	- allresults.js in order to direct the user to the view all results page
	 	- profile.js in order to direct the user to the profile page they clicked from the results 
	 
	- Add allResults.html to request the user_id, first_name, middle_name, last_name, profile_picture, groups_id, groups_name from the server
	  and display them in mutliple div boxes in either the people div or group div.

27/02/2014 - Rodger

	- Updated friendList.html to include session.js in order to store user_id in a session

26/02/2014 - Rodger
	
	- Added friendList.html to request the profile_picture and the user's name from the server and display them in multiple div boxes.

21/02/2014 - Philip

	- Uploaded the working "newsfeed.html". 
	- Please note that it is far from finished, but the aim was to provide us with a fundation to freely link the database to something. 
	- I personally think that it is pretty nice.
	- Please don't pay attention to the coloured borders ot the div elements, I needed them to CSS the html file. 
	- Unfortunatelly, we need quite a lot of CSS even for the simplest sceleton. 
	- NOTE: Some additional JS will be needed when we start experimenting returning the results from the database.

21/02/2014 - Tharman

	- Added a test UI for uploading and viewing photos to and from the database.
	- NOTE: YOU MUST ALREADY HAVE A COLLECTION WITH ID 1 FOR THIS TO WORK!!!

20/02/2014 - Tharman

	- Modified the client-side JavaScript to use serialisation of forms as opposed to passing in individual elements.
	- A far more efficient way of doing things, since we are actually using a fair number of forms.
	- Quite code-saving.
	- Abstract Ajax is still intact, so we can pass in requests without form serialisation if we want.
	- Again, more flexibility now.

19/02/2014 - Philip and Tharman

	- HTML date picker form is not supported across multiple browsers.
	- Replacing with the jQuery version.
	- Specifically, using "Display month & year menus".

18/02/2014 - Tharman

	- Made some notational changes.

18/02/2014 - Tharman

	- Modified 'landing.html' to include the sign-up stuff.

18/02/2014 - Philip

	- Added "login.html" containing the structure of our login page. We are working on linking the html with the database.

18/02/2014 - Tharman

	- Re-added 'ajax.js'.
	- Changed to 'login.js'.

18/02/2014 - Rodger

	- commented out ajax.js in landing.html -> not needed anymore

17/02/2014 - Philip

	- Added a basic HTML tamplate which may come in handy when creating the idividual UI elements. - Philip

17/02/2014 - Tharman

	- Added initial 'landing.html'.
