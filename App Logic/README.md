This README file contains information about all changes relating to the 'App Logic' folder. 

	NOTE: PLEASE CREATE A NEW ENTRY EVERYTIME YOU COMMIT A CHANGE TO THIS FOLDER.
===========================================================================================

22/02/2014 - Tharman

	- Implemented password SHA1 hash.
	- Tested successfully thanks to Abdi figuring out attribute size limitation.
	- Need to investigate security implications of this though, i.e. SHA1 has been generally replaced now by successors SHA2, and soon to be SHA3.

	- When signing up, implemented the creation of a default user collection for photos.
	- This uses the name '*' to avoid conflict with any of the user's other collections.
	- May be easier to use an additional column in the table to indicate that it is a default collection.

	- Also enforced email uniqueness through a query to the database when signing up.
	- No change to the database setup needed.
	- A user should NOT be able to sign up with an email already in use.

21/02/2014 - Tharman

	- Got upload and viewing of photos working with current setup!!!
	- Uploaded new photo js and php files.
	- NOTE: YOU MUST ALREADY HAVE A COLLECTION WITH ID 1 FOR THIS TO WORK!!!
	- Made some insignificant changes to sign in and sign up js and php files, so that less info put on client-side viewable js files.

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

