$("document").ready(function() {

	test(); // Run the test function.

});

function test() {
	$file = "user"; // Test with the 'user' CRUD operations.

    //$params = {"action":1, "first_name":"Tharman", "last_name":"Anantharajan", "email":"21@jumpstreet.com", "password":"HalEmmerich", "date_of_birth":"2001/01/04", "gender":1};
    $params = {"action":2, "user_id":1};
    //$params = {"action":3, "user_id":1, "first_name":"Tharman", "last_name":"Anantharajan", "email":"21@jumpstreet.com", "password":"Otacon", "date_of_birth":"2001/01/04", "gender":1};
    //$params = {"action":2, "user_id":1};

    ajax($file, $params, testSuccess, testFailure); // Call to ajax to generate, execute and return the result of the query.
}

function testSuccess(json) {
	if (typeof json === 'string') {
		alert(json);
	}
	else {
		alert(json.password);
	}
}

function testFailure(output) {
	alert(output);
}