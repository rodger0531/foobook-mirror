/*
@ authors: Philip, Tharman, Rodger and Abdi.
*/

/*
This file is responsible for connecting the HTML front-end to the PHP server-side.
*/
$("document").ready(function() {
//The following 3 lines are for testing purposes, they won't be present in production mode.
    $file = "user_PDO";
    // $sample = {"first_name":"Tharman", "last_name":"Anantharajan", "email":"21@jumpstreet.com", "password":"otacon", "date_of_birth":"2001/01/04", "gender":1};
    $sample = {"user_id":2};
    ajax($sample,$file);


    function ajax(sample, file){
        $.ajax({
            type: 'POST',
            url: 'http://localhost/'+file+'.php',
            data: sample,
            dataType:'html',
            success:  function(data){
                $rs = JSON.parse(data);
                alert($rs.user_id);
                alert($rs.first_name);
            },
            error: function(transaction,err){ 
                alert("error"+err.message);

            }
        });
    }
});
