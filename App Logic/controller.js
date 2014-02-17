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
                            email : $("#logInEmail"),
                            password : $("#logInPassword")
                        },
                        dataType:'JSON',
                        success: function(data)
                        {
                            alert("You are now logged in!");
                        },
                        error: function(transaction, err)
                        {
                            alert("Login failed!");
                        }
                    }
                );
            }
        )
    }
);