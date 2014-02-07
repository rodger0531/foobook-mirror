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
 * Following code will create a new collection row
 * All collection details are read from HTTP Post Request
 */

function create() {

    // array for JSON response
    $response = array();
     
    // check for required fields
    if (
    	isset($_POST['name']) 
    	) 

    {

     	$name = $_POST['name'];
    	
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql inserting a new row
        $result = mysql_query("INSERT INTO collection(name)VALUES('$name')");
     
        // check if row inserted or not
        if ($result) {
            // successfully inserted into database
            $response["success"] = 1;
            $response["message"] = "collection successfully created.";
     
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
 * Following code will get single collection details
 * A collection is identified by collection id (collection_id)
 */

function read () {

     
    // array for JSON response
    $response = array();
     
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
     
    // connecting to db
    $db = new DB_CONNECT();
     
    // check for post data
    if (isset($_GET["collection_id"])) {
        $collection_id = $_GET['collection_id'];
     
        // get a collection from collection table
        $result = mysql_query("SELECT * FROM collection WHERE collection_id = $collection_id");
     
        if (!empty($result)) {
            // check for empty result
            if (mysql_num_rows($result) > 0) {
     
                $result = mysql_fetch_array($result);
     
                $collection = array();

                $collection["name"] = $result['name'];
               
                // success
                $response["success"] = 1;
     
                // collection node
                $response["collection"] = array();
     
                array_push($response["collection"], $collection);
     
                // echoing JSON response
                echo json_encode($response);
            } else {
                // no collection found
                $response["success"] = 0;
                $response["message"] = "No collection found";
     
                // echo no collection JSON
                echo json_encode($response);
            }
        } else {
            // no collection found
            $response["success"] = 0;
            $response["message"] = "No collection found";
     
            // echo no collection JSON
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
 * Following code will update a collection information
 * A collection is identified by collection id (collection_id)
 */

function update () {

    // array for JSON response
    $response = array();
     
    // check for required fields
   if (
        isset($_POST['name']) 
        ) 
    {

        $name = $_POST['name'];
        
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql update row with matched collection_id
        $result = mysql_query("UPDATE collection SET name = '$name', WHERE collection_id = $collection_id");
     
        // check if row inserted or not
        if ($result) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "collection successfully updated.";
     
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
 * Following code will delete a collection from table
 * A collection is identified by collection id (collection_id)
 */

function delete () { //NOTE: Deletion still need to figured out.
 
    // array for JSON response
    $response = array();
     
    // check for required fields
    if (isset($_POST['collection_id'])) {
        $collection_id = $_POST['collection_id'];
     
        // include db connect class
        require_once __DIR__ . '/db_connect.php';
     
        // connecting to db
        $db = new DB_CONNECT();
     
        // mysql update row with matched collection_id
        $result = mysql_query("DELETE FROM collection WHERE collection_id = $collection_id");
     
        // check if row deleted or not
        if (mysql_affected_rows() > 0) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "collection successfully deleted";
     
            // echoing JSON response
            echo json_encode($response);
        } else {
            // no collection found
            $response["success"] = 0;
            $response["message"] = "No collection found";
     
            // echo no collection JSON
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