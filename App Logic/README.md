This README file contains information about all changes relating to the 'App Logic' folder. 

	NOTE: PLEASE CREATE A NEW ENTRY EVERYTIME YOU COMMIT A CHANGE TO THIS FOLDER.
===========================================================================================

08/03/2014 - Tharman

	- Created an overall 'homepage.js' controller file to control the document ready functions.
	- Should not be any conflicts in functionality.
	- Removed unnecessary 'profile.js' and 'allResults.js'.

06/03/2014 - Abdi 

	- Corrected 'search.js', 'usersearch.php', 'allUserSearch.php', 'allResultsSearch.js' files so that search works. For some reason there is a conflict between 'menu.js' and 'search.js'. The view all results div in the search results is shown when the page is loaded if the 'menu.js' is connected but when I comment out the 'menu.js' the view all results div is hidden which is what we need. 
	- Added comments to 'profile.js'

06/03/2014 - Tharman

	- Corrected the 'wallPost.php' file to use the updated field names currently being used for the 'message' table.

04/03/2014 - Tharman

	- Added updated sign in/sign up stuff.
	- Should be final.

	- Added the wall post stuff.
	- This adds in the functinality for uploading a post with optional image to the messages table.
	- Would probably need to describe the overall scheme in person - a bit complicated. Ask me later. Or read the github changelog.

03/03/2014 - Rodger

	- Added addBlockList.php
		- Inserts block_id of current user_id in session to the database.
	- Added removeBlockList.php
		- Removes block_id specified by the user, i.e. "unblock"
	- Added viewFriendBlock.php
		- Shows the user's block list on html (div created for each entry)
	- Added friendBlock.js
		- AJAX controller for block list.

03/03/2014 - Abdi and Philip

	- Added userSearch.php
		- queries the database for user_id, first_name, middle_name, last_name and profile_picture from the user table with a limit of 5 and returns the results.
	- Added groupSearch.php 
		- queries the database for groups_id and name from the groups table with a limit of 2 and returns the results.
	- Added allUserSearch.php 
		- queries the database for user_id, first_name, middle_name, last_name and profile_picture from the user table with no limits and returns the results.
	- Added allGroupSearch.php 
		- queries the database for groups_id and name from the groups table with no limits and returns the results.
	- Added search.js
		- The success function loops through each element of the returned array of objects, puts the appropriate data in its own div boxes, together in a collective div, to present the data as a list in newsfeed.html in the result div in the search bar. The results are limit to a maximum of 5 user results and maximum of 2 groups results.
	- Added profile.js
		- Gets the name (i.e. user_id or groups_id) of the div the user clicks on in the result div under the search bar and directs them to the profile.html. 
		- NOTE: profile.html is used for test purpose and in fact does not exit. In the future, this would direct the user someone's profile page. 
	- Added allResults.js
		- directs the user to allResults.html where the user can view all results
	- Added allResultsSeach.js
		- The success function loops through each element of the returned array of objects, puts the appropriate data in its own div boxes, together in a collective div, to present the data as a list in allResults.html. The results are have no limits. 

27/02/2014 - Rodger

	- Added session.js to be able to store relevant information into session to be used later (i.e. user_id). Adapted the script from http://dreamerslab.com/blog/en/javascript-session/, and also instructions are on this webpage.
	- Updated friendList.js to use user_id from session.


26/02/2014 - Rodger

	- Added friendList.js
		- The success function loops through each element of the returned array of objects, puts the appropriate data in its own div boxes, together in a collective div, to present the data as a list in the friendList.html.
		- NOTE: need to change parameters to session's user_id
	- Added friendList.php
		- Query statement joins two tables in order to query the server for first_name, last_name and profile_picture.
		- Loops through the returned array of objects from query.php, and encodes them through base64 in order for it to be passed through json_encode.
		- This looping fucntion will have to be used in every json_encode for fetchAll to work in query.php.
	- Altered viewPhoto.js
		- The array obtained from AJAX has been changed due to fetchAll in query.php, so the method to call array elements of objects has been changed.
	- Altered viewPhoto.php
		-Similar as to the reason above, changed to adopt the fetchAll change made to query.php.

25/02/2014 - Tharman

	- Removed blowfish encryption files by common consensus.
	- Made numerous changes to files - see commit for details.
	- Using bcrypt password hashing.
	- Validation for empty() input fields.

25/02/2014 - Philip 

	- Successfully managed to hash the passwords (which is the easy part). Now we are using the so called Blowfish encryption algorythm. The cool part is that the code generates a unique salt code which improves security even more.
	- Setup_database.php was populated for the hasing part we needed to add another column called "salt" it stores the randomly generated salt code. It is reuired for the verifycation part. Furthermore, the password length had to be increased to fit the new password.
	- Sing in function still need to be finished. Unfortunately, at this stage it doesn't manage to match the pass in my opinion it simply does not take the salt element. But anyway please check the code so we can sort this out together.


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

