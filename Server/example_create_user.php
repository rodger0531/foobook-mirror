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
	isset($_POST['gender']) 
	&& isset($_POST['user_id'])
	&& isset($_POST['pregnant']) 
	&& isset($_POST['yearOfBirth'])
	&& isset($_POST['weight'])
	&& isset($_POST['height'])
	&& isset($_POST['above2500m'])
	&& isset($_POST['highestAltitude'])
	&& isset($_POST['stroke'])
	&& isset($_POST['smoke'])
	&& isset($_POST['previousAMS'])
	&& isset($_POST['AMSaltitude'])
	&& isset($_POST['previousHACE'])
	&& isset($_POST['HACEaltitude'])
	&& isset($_POST['previousHAPE'])
	&& isset($_POST['HAPEaltitude'])
	&& isset($_POST['heartDisease'])
	&& isset($_POST['highBloodPressure'])
	&& isset($_POST['asthma'])
	&& isset($_POST['anaemia'])
	&& isset($_POST['diabetes'])
	&& isset($_POST['otherMedicalHistory'])
	&& isset($_POST['bloodPressureMedication'])
	&& isset($_POST['highCholesterolMedication'])
	&& isset($_POST['diabetesMedication'])
	&& isset($_POST['aspirin'])
	&& isset($_POST['painkillers'])
	) {
 	$user_id = $_POST['user_id'];
   	$gender = $_POST['gender'];
    	$pregnant = $_POST['pregnant'];
    	$yearOfBirth = $_POST['yearOfBirth'];
	$weight = $_POST['weight'];
	$height = $_POST['height'];
	$above2500m = $_POST['above2500m'];
	$highestAltitude = $_POST['highestAltitude'];
	$stroke = $_POST['stroke'];
	$smoke = $_POST['smoke'];
	$previousAMS = $_POST['previousAMS'];
	$AMSaltitude = $_POST['AMSaltitude'];
	$previousHACE = $_POST['previousHACE'];
	$HACEaltitude = $_POST['HACEaltitude'];
	$previousHAPE = $_POST['previousHAPE'];
	$HAPEaltitude = $_POST['HAPEaltitude'];
	$heartDisease = $_POST['heartDisease'];
	$highBloodPressure = $_POST['highBloodPressure'];
	$asthma = $_POST['asthma'];
	$anaemia = $_POST['anaemia'];
	$diabetes = $_POST['diabetes'];
	$otherMedicalHistory = $_POST['otherMedicalHistory'];
	$bloodPressureMedication = $_POST['bloodPressureMedication'];
	$highCholesterolMedication = $_POST['highCholesterolMedication'];
	$diabetesMedication = $_POST['diabetesMedication'];
	$aspirin = $_POST['aspirin'];
	$painkillers = $_POST['painkillers'];
 
    // include db connect class
    require_once __DIR__ . '/db_connect.php';
 
    // connecting to db
    $db = new DB_CONNECT();
 
    // mysql inserting a new row
    $result = mysql_query("INSERT INTO user(user_id, gender,pregnant,yearOfBirth,weight,height,above2500m,highestAltitude,stroke,smoke,previousAMS,AMSaltitude,previousHACE,HACEaltitude,previousHAPE,HAPEaltitude,heartDisease,highBloodPressure,asthma,anaemia,diabetes,otherMedicalHistory,bloodPressureMedication,highCholesterolMedication,diabetesMedication,aspirin,painkillers)VALUES('$user_id','$gender','$pregnant','$yearOfBirth','$weight','$height','$above2500m','$highestAltitude','$stroke','$smoke','$previousAMS','$AMSaltitude','$previousHACE','$HACEaltitude','$previousHAPE','$HAPEaltitude','$heartDisease','$highBloodPressure','$asthma','$anaemia','$diabetes','$otherMedicalHistory','$bloodPressureMedication','$highCholesterolMedication','$diabetesMedication','$aspirin','$painkillers')");
 
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