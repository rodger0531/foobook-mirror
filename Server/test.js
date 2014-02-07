$file = "update_user";
$sample = {"first_name":"Philip", "last_name":"T", "email":"def@x.com","password":"password","date_of_birth":"2014/05/20","gender":1,"country":"London"};
ajax($sample,$file);


function ajax(sample,file){
    $.ajax({
        type: 'POST',
        url: 'http://localhost/'+file+'.php',
        data: sample,
        dataType:'html',   
        success:  function(data){
            alert("success");
        },
        error: function(transaction,err){ //sql fail action
                                      alert("error"+err.message);
        }
    });
}

// function success(){} //sql success action

// function fail(transaction,err){ //sql fail action
// //     alert("error"+err.message);
//  }