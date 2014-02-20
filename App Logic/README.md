This README file contains information about all changes relating to the 'App Logic' folder. 

	NOTE: PLEASE CREATE A NEW ENTRY EVERYTIME YOU COMMIT A CHANGE TO THIS FOLDER.
===========================================================================================

20/02/2014 - Tharman

	- Changed the query structure to be more concise.
	- More specifically didn't actually need to construct SQL query statements. These are defined in the transaction PHP files.
	- Parameter binding is still in place, so security is still intact from using Prepared Statements.
	- More flexibility now.
	- Tested and works.

	- Modified the client-side JavaScript to use serialisation of forms as opposed to passing in individual elements.
	- A far more efficient way of doing things, since we are actually using a fair number of forms.
	- Quite code-saving.
	- Abstract Ajax is still intact, so we can pass in requests without form serialisation if we want.
	- Again, more flexibility now.

20/02/2014 - Philip and Abdi

	- We created a separate folder where we pushed the working code for picture uploadind and reading. NOTE: The code still needs to be adjusted to our original overall app design. We are not quite sure but we think that we need to fit in Ajax to send the data through, because now we use only PHP for the purpose.


19/02/2014 - Tharman

	- Removed 'async: false' from 'ajax.js' since it makes no difference.

18/02/2014 - Tharman.

	- Made some notational changes.

18/02/2014 - Tharman

	- Added 'signup.js' and 'signup.php'. Working - no output messages.

18/02/2014 - Tharman

	- Login works correctly.
	- Updated 'login.js' and 'login.php'.

18/02/2014 - Tharman

	- Updated the files to abstractly use ajax function.
	- Cleaned-up files.

18/02/2014 - Rodger

	- Modified login.php -> added header("Access-Control-Allow-Origin: *") to allow communication between ajax and php.
		- NOT NECESSARY.
	- Modified controller.js -> added .val() to the $ variable for the correct call for value from html forms.

17/02/2014 - Tharman

	- Adding updated versions of files.
	- Started work on 'login.php'.

13/02/2014 - Tharman, Philip, Rodger

	- Going to create individual PHP files/classes for each page in the UI, i.e. a Homepage class, etc.
	- Implemented a basic version of 'homepage.php' - NOT TESTED!!!

13/02/2014 - Tharman, Philip, Rodger

	- populateNewsFeed() works!!! Needs refinement.

