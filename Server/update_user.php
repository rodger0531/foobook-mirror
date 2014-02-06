<?php
 
/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */

//enable CORS
 header("Access-Control-Allow-Origin: *");
 
// array for JSON response
$response = array();
 
// check for required fields
if (
	isset($_POST['first_name'])
	&& isset($_POST['middle_name']) 
	&& isset($_POST['last_name'])
	&& isset($_POST['email'])
	&& isset($_POST['password'])
	&& isset($_POST['date_of_birth'])
	&& isset($_POST['gender'])
	&& isset($_POST['city'])
	&& isset($_POST['country'])
	&& isset($_POST['profile_picture'])
	&& isset($_POST['profile_visibility'])
	&& isset($_POST['chat_visibility'])
	) {
   	$first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$date_of_birth = $_POST['date_of_birth'];
	$gender = $_POST['gender'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$profile_picture = $_POST['profile_picture'];
	$profile_visibility = $_POST['profile_visibility'];
	$chat_visibility = $_POST['chat_visibility'];
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
 
    // mysql inserting a new row
    $result = mysql_query("INSERT INTO user(first_name,middle_name,last_name,email,password,date_of_birth,gender,city,country,profile_picture,profile_visibility,chat_visibility)VALUES('$first_name','$middle_name','$last_name','$email','$password','$date_of_birth','$gender','$city','$country','$profile_picture','$profile_visibility','$chat_visibility')"); 
    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "user successfully created.";
 
        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
 
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
 
    // echoing JSON response
    echo json_encode($response);
}
?>