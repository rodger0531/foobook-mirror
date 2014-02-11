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
            // rs=JSON.parse(data);
            // alert(rs.rows.item(0));
        },
        error: function(transaction,err){ //sql fail action
                                      alert("error"+err.message);
                                      
        }
    });
}
/*
function success(data){
    alert(data)
} //sql success action

function fail(transaction,err){ //sql fail action
    alert("error"+err.message);
}
*/