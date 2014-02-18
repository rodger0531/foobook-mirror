$("document").ready
(
    function()
    {
        $("#submitlogin").click
        (
            function()
            {
                $.ajax
                (
                    {
                        type: 'POST',
                        url: 'http://localhost/login.php',
                        data:
                        {
                            email : $("#logInEmail").value,
                            password : $("#logInPassword").value
                        },
                        dataType:'JSON',
                        success: function(data)
                        {
                            alert(data);
                        },
                        error: function(transaction, err)
                        {
                            alert("Ajax failed!");
                        }
                    }
                );
            }
        )
    }
);