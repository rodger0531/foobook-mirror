<?php


//enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
//The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
 header("Access-Control-Allow-Origin: *");

$action = $_POST['action'];
echo($action);

switch ($action) {
    case 1:
        create();
        echo "Yes!";
        break;
    case 2:
        read();
        break;
    case 3:
        update();
        break;
    case 4:
        delete();
        break;    
    default:
        echo "We are fucked!";
        break;
}

/*
 * Following code will create a new user row
 * All user details are read from HTTP Post Request
 */


function create() {

    // array for JSON response
    $response = array();
     
    // check for required fields
    if (
    	isset($_POST['first_name']) 
    	//&& isset($_POST['middle_name']) // We are not sure whether we need to set it here.
    	&& isset($_POST['last_name']) 
    	&& isset($_POST['email'])
    	&& isset($_POST['password'])
    	&& isset($_POST['date_of_birth'])
    	//&& isset($_POST['gender'])
    	//&& isset($_POST['city'])
    	//&& isset($_POST['country'])
    	//&& isset($_POST['profile_picture'])
    	// && isset($_POST['profile_visibility'])
    	// && isset($_POST['chat_visibility'])
    	) 

    {

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
        $result = mysql_query("INSERT INTO user(first_name, middle_name, last_name, email, password, date_of_birth, gender, city, country, profile_picture, profile_visibility, chat_visibility)VALUES('$first_name', '$middle_name', '$last_name','$email', '$password', '$date_of_birth', '$gender', '$city', '$country', '$profile_picture', '$profile_visibility', '$chat_visibility' )");
     
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
}



/*
 * Following code will get single user details
 * A user is identified by user id (user_id)
 */


function read () {

     
    // array for JSON response
    $response = array();
     
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
     
    // connecting to db
    $db = new DB_CONNECT();
     
    // check for post data
    if (isset($_GET["user_id"])) {
        $user_id = $_GET['user_id'];
     
        // get a user from users table
        $result = mysql_query("SELECT * FROM user WHERE user_id = $user_id");
     
        if (!empty($result)) {
            // check for empty result
            if (mysql_num_rows($result) > 0) {
     
                $result = mysql_fetch_array($result);
     
                $user = array();

                $user["first_name"] = $result['first_name'];
                $user["middle_name"] = $result['middle_name'];
                $user["last_name"] = $result['last_name'];
                $user["email"] = $result['email'];
                $user["password"] = $result['password'];
                $user["date_of_birth"] = $result['date_of_birth'];
                $user["gender"] = $result['gender'];
                $user["city"] = $result['city'];
                $user["country"] = $result['country'];
                $user["profile_picture"] = $result['profile_picture'];
                $user["profile_visibility"] = $result['profile_visibility'];
                $user["chat_visibility"] = $result['chat_visibility'];


                // success
                $response["success"] = 1;
     
                // user node
                $response["user"] = array();
     
                array_push($response["user"], $user);
     
                // echoing JSON response
                echo json_encode($response);
            } else {
                // no user found
                $response["success"] = 0;
                $response["message"] = "No user found";
     
                // echo no users JSON
                echo json_encode($response);
            }
        } else {
            // no user found
            $response["success"] = 0;
            $response["message"] = "No user found";
     
            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // required field is missing
        $response["success"] = 0;
        $response["message"] = "Required field(s) is missing";
     
        // echoing JSON response
        echo json_encode($response);
    }

}

/*
 * Following code will update a user information
 * A user is identified by user id (user_id)
 */

function update () {

    // array for JSON response
    $response = array();
     
    // check for required fields
   if (
        isset($_POST['first_name']) 
        //&& isset($_POST['middle_name']) // We are not sure whether we need to set it here.
        && isset($_POST['last_name']) 
        && isset($_POST['email'])
        && isset($_POST['password'])
        && isset($_POST['date_of_birth'])
        //&& isset($_POST['gender'])
        //&& isset($_POST['city'])
        //&& isset($_POST['country'])
        && isset($_POST['profile_picture'])
        && isset($_POST['profile_visibility'])
        && isset($_POST['chat_visibility'])
        ) 
    {

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
     
        // mysql update row with matched user_id
        $result = mysql_query("UPDATE users SET first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name', email = '$email', password = '$password', date_of_birth = '$date_of_birth', gender = '$gender', city = '$city', country = '$country', profile_picture = '$profile_picture', profile_visibility = '$profile_visibility', chat_visibility = '$chat_visibility', WHERE user_id = $user_id");
     
        // check if row inserted or not
        if ($result) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "user successfully updated.";
     
            // echoing JSON response
            echo json_encode($response);
        } else {
     
        }
    } else {
        // required field is missing
        $response["success"] = 0;
        $response["message"] = "Required field(s) is missing";
     
        // echoing JSON response
        echo json_encode($response);
    }

}

/*
 * Following code will delete a user from table
 * A user is identified by user id (user_id)
 */

function delete () {
 
    // array for JSON response
    $response = array();
     
    // check for required fields
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
     
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql update row with matched user_id
        $result = mysql_query("DELETE FROM users WHERE user_id = $user_id");
     
        // check if row deleted or not
        if (mysql_affected_rows() > 0) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "user successfully deleted";
     
            // echoing JSON response
            echo json_encode($response);
        } else {
            // no user found
            $response["success"] = 0;
            $response["message"] = "No user found";
     
            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // required field is missing
        $response["success"] = 0;
        $response["message"] = "Required field(s) is missing";
     
        // echoing JSON response
        echo json_encode($response);
    }
}

?>