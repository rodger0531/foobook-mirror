$("document").ready(function()
{
    $("#submitLogin").click(function()
    {
        ajax(
            'login',
            {
                'email' : $("#loginEmail").val(),
                'password' : $("#loginPassword").val()
            },
            loginSuccess,
            loginFailure);
    });
});

function loginSuccess(data)
{
    alert(data);
}

function loginFailure(error)
{
    alert(error);
}