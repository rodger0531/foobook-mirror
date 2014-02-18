$("document").ready(function()
{
    $("#signUpSubmit").click(function()
    {
        ajax(
            'signUp',
            {
                'first_name' : $('#firstName').val(),
                'last_name' : $('#lastName').val(),
                'email' : $('#signUpEmail').val(),
                'password' : $('#signUpPassword').val(),
                'date_of_birth' : $('#dateOfBirth').val(),
                'gender' : $('#gender').val()
            },
            signUpSuccess
        );
    });
});

function signUpSuccess(data)
{
    alert(data['response']);
}