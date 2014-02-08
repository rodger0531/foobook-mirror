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
 * Following code will create a new circle row
 * All circle details are read from HTTP Post Request
 */

function create() { 

/*This function is not applicable in this case. Unless we do not give the opportunity to the circle to create their own circle containing friends they would like to have in.
*/

    // array for JSON response
    $response = array();
     
    // check for required fields
    
    # Field go here ... 

        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql inserting a new row
        
        # The inserted fields go in here ...
     
        // check if row inserted or not
        if ($result) {
            // successfully inserted into database
            $response["success"] = 1;
            $response["message"] = "circle successfully created.";
     
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
 * Following code will get single circle details
 * A circle is identified by circle id (circle_id)
 */

function read () {

     
    // array for JSON response
    $response = array();
     
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
     
    // connecting to db
    $db = new DB_CONNECT();
     
    // check for post data
    if (isset($_GET["circle_id"])) {
        $circle_id = $_GET['circle_id'];
     
        // get a circle from circle table
        $result = mysql_query("SELECT * FROM circle WHERE circle_id = $circle_id");
     
        if (!empty($result)) {
            // check for empty result
            if (mysql_num_rows($result) > 0) {
     
                $result = mysql_fetch_array($result);
     
                $circle = array();

                $circle["circle_name"] = $result['circle_name'];

                // success
                $response["success"] = 1;
     
                // circle node
                $response["circle"] = array();
     
                array_push($response["circle"], $circle);
     
                // echoing JSON response
                echo json_encode($response);
            } else {
                // no circle found
                $response["success"] = 0;
                $response["message"] = "No circle found";
     
                // echo no circle JSON
                echo json_encode($response);
            }
        } else {
            // no circle found
            $response["success"] = 0;
            $response["message"] = "No circle found";
     
            // echo no circle JSON
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
 * Following code will update a circle information
 * A circle is identified by circle id (circle_id)
 */

function update () {

/* Updating a cirlce means that we have to give the users the option to create their own circle, i.e. they can add and remove users from the given circle. At this stage only tha name of the circle can be updated.*/

    // array for JSON response
    $response = array();
     
    // check for required fields
   if (
        isset($_POST['circle_name']) 
        ) 
    {

        $circle_name = $_POST['circle_name'];
        
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql update row with matched circle_id
        $result = mysql_query("UPDATE circle SET circle_name = '$circle_name', WHERE cirlce_name = $cirlce_name");
     
        // check if row inserted or not
        if ($result) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "circle successfully updated.";
     
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
 * Following code will delete a circle from table
 * A circle is identified by circle id (circle_id)
 */

function delete () { //NOTE: Deletion still need to figured out.
 
    // array for JSON response
    $response = array();
     
    // check for required fields
    if (isset($_POST['circle_id'])) {
        $circle_id = $_POST['circle_id'];
     
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql update row with matched circle_id
        $result = mysql_query("DELETE FROM circle WHERE circle_id = $circle_id");
     
        // check if row deleted or not
        if (mysql_affected_rows() > 0) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "circle successfully deleted";
     
            // echoing JSON response
            echo json_encode($response);
        } else {
            // no circle found
            $response["success"] = 0;
            $response["message"] = "No circle found";
     
            // echo no circle JSON
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