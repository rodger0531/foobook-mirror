$("document").ready(function()
{
    $("#signUpForm").on('submit', function(event)
    {
        event.preventDefault();
        ajax(
            'signUp',                       // PHP file to call on.
            $("#signUpForm").serialize(),   // Data from serialised form with user input.
            signUpSuccess                // Callback method to use on success.
        );
    });
});

function signUpSuccess(data)
{
    alert(data);
}