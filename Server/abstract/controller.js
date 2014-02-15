$("document").ready
(
    function()
    {
	   test(); // Run the test function.
    }
);

/*
 * Run the tests in this order while looking at phpMyAdmin: CREATE, READ, UPDATE, READ, DELETE, READ
 */
function test()
{
    /*
    // CREATE
    var sqlParams =
    {
        'INSERT INTO' : ['user'],
        'SET' : ['first_name', 'last_name', 'email', 'password', 'date_of_birth', 'gender']
    };
    var dataParams =
    {
        'first_name' : 'Tharman',
        'last_name' : 'Anantharajan',
        'email' : '21@jumpstreet.com',
        'password' : 'HalEmmerich',
        'date_of_birth' : '2001/01/04',
        'gender' : 1
    };
    */
    
    // READ
    var sqlParams =
    {
    	'SELECT' : ['password'],
        'FROM' : ['user'],
    	'WHERE' : {'user_id' : null}
    };
    var dataParams =
    {
        'user_id' : 1
    };
    
    /*
    // UPDATE
    var sqlParams =
    {
        'UPDATE' : ['user'],
        'SET' : ['first_name', 'last_name', 'email', 'password', 'date_of_birth', 'gender'],
        'WHERE' : {'user_id' : null}
    };
    var dataParams =
    {
        'user_id' : 1,
        'first_name' : 'Rodger',
        'last_name' : 'Lo',
        'email' : 'rush@hour.com',
        'password' : 'Otacon',
        'date_of_birth' : '2001/01/04',
        'gender' : 1
    };
    */
    /*
    // DELETE
    var sqlParams =
    {
        'DELETE FROM' : ['user'],
        'WHERE' : {'user_id' : null}
    };
    var dataParams =
    {
        'user_id' : 1
    };
    */
    ajax(sqlParams, dataParams, testSuccess, testFailure); // Call to ajax to generate, execute and return the result of the query.
}

function testSuccess(result)
{
	alert(result.password);
}

function testFailure(result)
{
	alert(result);
}