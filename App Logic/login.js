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
            loginSuccess
        );
    });
});

function loginSuccess(data)
{
    alert(data['response']);
}