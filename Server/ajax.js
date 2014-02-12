/*
 * @author Philip, Tharman, Rodger and Abdi.
 */

/*
 * This file is responsible for connecting the HTML front-end to the PHP server-side.
 */
$("document").ready(function() {

    // The following lines are for testing purposes, and won't be present in production mode.
    $file = "user";
    //$params = {"action":1, "first_name":"Tharman", "last_name":"Anantharajan", "email":"21@jumpstreet.com", "password":"Otacon", "date_of_birth":"2001/01/04", "gender":1};
    $params = {"action":2, "user_id":1};
    //$params = {"action":3, "user_id":1, "first_name":"Tharman", "last_name":"Anantharajan", "email":"21@jumpstreet.com", "password":"HalEmmerich", "date_of_birth":"2001/01/04", "gender":1};
    //$params = {"action":4, "user_id":1};
    ajax($file, $params);

    function ajax(file, params){
        $.ajax({
            type: 'POST',
            url: 'http://localhost/'+file+'.php',
            data: params,
            dataType:'HTML',
            success: function(data) {
                var rs = JSON.parse(data);
                if (typeof rs === 'string') {
                    alert(rs);
                }
                else {
                    alert(rs.password);
                }
            },
            error: function(transaction, err) { 
                alert(rs = "Error: " + err.message);
            }
        });        
    }

});