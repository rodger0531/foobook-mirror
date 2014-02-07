<?php


/*enable CORS (Cross Origin Resource Sharing)- CORS allows our JS files to be run on client side.
The asterisk wild-card permits scripts hosted on any site to load your resources; listing one or more specific <base URI> will permit scripts hosted on the specified site(s) -- and no others -- to load your resources.
*/
 header("Access-Control-Allow-Origin: *");

$action = $_POST['action'];

echo($action);

switch ($action) {
    case 1:
        create();
        echo "Creation works!";
        break;
    case 2:
        read();
        echo "Reading works!";
        break;
    case 3:
        update();
        echo "Updating works!";
        break;
    case 4:
        delete();
        echo "Deletion works!";
        break;    
    default:
        echo "None of the CRUD option is working!";
        break;
}

/*
 * Following code will change collection_friendVisibility
 * All collection_friendVisibility details are read from HTTP Post Request
 */

function create() { //Not applicable

    // array for JSON response
    $response = array();
     
    // check for required fields
    # Not applicable for collection_friendVisibility.

    {

        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql inserting a new row
        # Not applicable for collection_friendVisibility.
     
        // check if row inserted or not
        if ($result) {
            // successfully inserted into database
            $response["success"] = 1;
            $response["message"] = "collection_friendVisibility successfully created.";
     
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
 * Following code will get single collection_friendVisibility details
 * A collection_friendVisibility is identified by collection_id and friend_id
 */

function read () {

     
    // array for JSON response
    $response = array();
     
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
     
    // connecting to db
    $db = new DB_CONNECT();
     
    // check for post data
    if (isset($_GET["collection_id"])
        &&isset($_GET["friend_id"])) { //NOTE: We need both to identify circle collection.
        $collection_id = $_GET['collection_id'];
        $friend_id = $_GET['friend_id'];
     
        // get a visibility from collection_friendVisibility table
        $result = mysql_query("SELECT * FROM collection_friendVisibility WHERE collection_id = $collection_id, friend_id = $friend_id");
     
        if (!empty($result)) {
            // check for empty result
            if (mysql_num_rows($result) > 0) {
     
                $result = mysql_fetch_array($result);
     
                $visibility = array();

                $collection_friendVisibility["collection_id"] = $result['collection_id'];
                $collection_friendVisibility["friend_id"] = $result['friend_id'];
                
                // success
                $response["success"] = 1;
     
                // visibility node
                $response["collection_friendVisibility"] = array();
     
                array_push($response["collection_friendVisibility"], $collection_friendVisibility);
     
                // echoing JSON response
                echo json_encode($response);
            } else {
                // no collection_friendVisibility found
                $response["success"] = 0;
                $response["message"] = "No collection_friendVisibility found";
     
                // echo no collection_friendVisibility JSON
                echo json_encode($response);
            }
        } else {
            // no collection_friendVisibility found
            $response["success"] = 0;
            $response["message"] = "No collection_friendVisibility found";
     
            // echo no collection_friendVisibility JSON
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
 * Following code will update a collection_friendVisibility information
 * A collection_friendVisibility is identified by collection_id and cirlce_id
 */

function update () {

    // array for JSON response
    $response = array();
     
    // check for required fields
   if (
        isset($_POST['visibility_setting']) //NOTE: We have this attribute in the ERD diagram but not in the database.
        ) 
    {

        $visibility_setting = $_POST['visibility_setting'];
     
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql update row with matched visibility_id
        $result = mysql_query("UPDATE collection_friendVisibility SET visibility_setting = '$visibility_setting', WHERE collection_id = $collection_id, friend_id = $friend_id");
     
        // check if row inserted or not
        if ($result) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "collection_friendVisibility successfully updated.";
     
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
 * Following code will delete a collection_friendVisibility from table
 * A collection_friendVisibility is identified by collection_id and friend_id
 */

function delete () { //NOTE: Deletion still need to figured out.
    
//This function is not applicable for collection_friendVisibility

    // array for JSON response
    $response = array();
     
    // check for required fields
    # Not applicable ...
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql update row with matched visibility_id
        # Not applicable ...
     
        // check if row deleted or not
        if (mysql_affected_rows() > 0) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "collection_friendVisibility successfully deleted";
     
            // echoing JSON response
            echo json_encode($response);
        } else {
            // no collection_friendVisibility found
            $response["success"] = 0;
            $response["message"] = "No collection_friendVisibility found";
     
            // echo no collection_friendVisibility JSON
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