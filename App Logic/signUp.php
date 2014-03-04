<?php

require 'password.php'; // For password hashing functions.

require 'query.php'; // For querying to the database.

if (
	empty($_POST['first_name'])
	|| empty($_POST['last_name'])
	|| empty($_POST['email'])
	|| empty($_POST['password'])
	|| empty($_POST['date_of_birth'])
	|| empty($_POST['gender'])
	)
{
	$result = array('outcome' => 0, 'response' => "All input fields must be completed!");
	echo json_encode($result);
	return;
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$date_of_birth = $_POST['date_of_birth'];
$gender = $_POST['gender'];

$hash = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12)); // Use bcrypt algorithm to hash the password.

// Verify that the password has been correctly hashed.
if (!password_verify($password, $hash))
{
	die;
}

/*
 * Check if the email address entered is already taken.
 */

// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
$action = 2; // 2 indicates that the database is being READ from.

// Define a SQL query that can read through the user table to match the email address.
$query = "
SELECT count(*) AS count
FROM user
WHERE email = :email
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'email' => $email
);

$result = query($action, $query, $params);

if ($result['outcome'] === 1)
{
	if ($result['response'][0]->count !== '0')
	{
		echo json_encode("There is already an account linked with this email address!");
		return;
	}
}
else
{
	die;
}

/*
 * Execute the creation of the new user record.
 */

// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
$action = 1; // 1 indicates that a record is being INSERTED into the database.

// Define a SQL query that can create a record with the given user's details.
$query = "
INSERT INTO user
SET	first_name = :first_name,
	last_name = :last_name,
	email = :email,
	password = :password,
	date_of_birth = :date_of_birth,
	gender = :gender
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'first_name' => $first_name,
	'last_name' => $last_name,
	'email' => $email,
	'password' => $hash,
	'date_of_birth' => $date_of_birth,
	'gender' => $gender
);

$result = query($action, $query, $params);

if ($result['outcome'] === 1)
{
	echo json_encode($result);
}
else
{
	die;
}

/*
 * Set a temporary variable to hold the user's newly generated id.
 */

$user_id = $result['insertId'];

/*
 * Create a default collection for the user's profile pictures.
 */

// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
$action = 1; // 1 indicates that a record is being INSERTED into the database.

// Define a SQL query that can create a user collection.
$query = "
INSERT INTO collection
SET	user_id = :user_id,
	name = :name
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id' => $user_id,
	'name' => 'profile_pictures'
);

$result = query($action, $query, $params);

if ($result['outcome'] === 0)
{
	die;
}

/*
 * Set a temporary variable to hold the user's newly generated default photo collection.
 */

$profile_picture_collection_id = $result['insertId'];

/*
 * Create a default collection for the user's photos.
 */

// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
$action = 1; // 1 indicates that a record is being INSERTED into the database.

// Define a SQL query that can create a user collection.
$query = "
INSERT INTO collection
SET	user_id = :user_id,
	name = :name
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id' => $user_id,
	'name' => 'uploaded_photos'
);

$result = query($action, $query, $params);

if ($result['outcome'] === 0)
{
	die;
}

/*
 * Set a temporary variable to hold the user's newly generated default photo collection.
 */

$default_photo_collection_id = $result['insertId'];

/*
 * Update the user's details with the new default collection details.
 */

// Define which type of database transaction is being attempted here, e.g. INSERT, READ, etc.
$action = 3; // 3 indicates that a record is being UPDATED in the database.

// Define a SQL query that can update the user's details.
$query = "
UPDATE user
SET	profile_picture_collection_id = :profile_picture_collection_id,
	default_photo_collection_id = :default_photo_collection_id
WHERE user_id = :user_id
";

// Define the parameters of the query depending on the information the user inputted.
$params =
array(
	'user_id' => $user_id,
	'profile_picture_collection_id' => $profile_picture_collection_id,
	'default_photo_collection_id' => $default_photo_collection_id
);

$result = query($action, $query, $params);

if ($result['outcome'] === 0)
{
	die;
}

?>