This README file contains information about all changes relating to the 'UI' folder. 

	NOTE: PLEASE CREATE A NEW ENTRY EVERYTIME YOU COMMIT A CHANGE TO THIS FOLDER.
=======================================================================================

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
