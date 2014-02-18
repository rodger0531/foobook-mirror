$("document").ready(function()
{
    $("#signup").click(function()
    {
        ajax(
            'signup',
            {
                'first_name' : $("#firstName").val(),
                'last_name' : $("#lastName").val(),
                'email' : $("#setEmail").val(),
                'password' : $("#setPassword").val(),
                'gender' : $("#gender").val()
            },
            signupSuccess
        );
    });
});

function signupSuccess(data)
{
    alert(data['response']);
}