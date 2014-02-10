$file = "user_PDO";
$sample = {'user_id':1};
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

// function success(){} //sql success action

// function fail(transaction,err){ //sql fail action
// //     alert("error"+err.message);
//  }