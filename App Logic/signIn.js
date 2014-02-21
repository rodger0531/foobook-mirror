$("document").ready(function()
{
    $("#signInForm").on('submit', function(event)
    {
        event.preventDefault();
        ajax(
            'signIn',                       // PHP file to call on.
            $("#signInForm").serialize(),   // Data from serialised form with user input.
            signInSuccess                   // Callback method to use on success.
        );
    });
});

function signInSuccess(data)
{
    alert(data);
}