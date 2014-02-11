/*
@ authors: Philip, Tharman, Rodger and Abdi.
*/

/*
This file is responsible for connecting the HTML front-end to the PHP server-side.
*/

//The following 3 lines are for testing purposes, they won't be present in production mode.
$file = "user";
$sample = {"first_name":"Tharman", "last_name":"Anantharajan", "email":"21@jumpstreet.com", "password":"otacon", "date_of_birth":"2001/01/04", "gender":1};
ajax($sample,$file);


function ajax(sample,file){
    $.ajax({
        type: 'POST',
        url: 'http://localhost/'+file+'.php',
        data: sample,
        dataType:'html',
        success:  function(data){
            alert(data);
        },
        error: function(transaction,err){ 
            alert("error"+err.message);
                                      
        }
    });
}
