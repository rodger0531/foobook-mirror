$("document").ready(function()
{
    $("#signInSubmit").click(function()
    {
        ajax(
            'signIn',
            {
                'email' : $("#signInEmail").val(),
                'password' : $("#signInPassword").val()
            },
            signInSuccess
        );
    });
});

function signInSuccess(data)
{
    alert(data['response']);
}