$(function()
{
    $("#signInForm").on('submit', function(event)
    {
        event.preventDefault();
        ajax(
            'pages/landing/signIn',                       // PHP file to call on.
            $("#signInForm").serialize(),   // Data from serialised form with user input.
            signInSuccess                   // Callback method to use on success.
        );
    });

    $("#signUpForm").on('submit', function(event)
    {
        event.preventDefault();
        alert($("#signUpForm").serialize());
        ajax(
            'pages/landing/signUp',                       // PHP file to call on.
            $("#signUpForm").serialize(),   // Data from serialised form with user input.
            signUpSuccess                   // Callback method to use on success.
        );
    });
});

function signInSuccess(data)
{
    if (data['outcome'] === 1)
    {
        Session.set('user_id', data['response']); // Store the user's id in a session linked to the window.
        Session.set('userWall_id', data['response']); // Store the user's id in a session linked to the window.
        Session.set('groupWall_id', ''); // Create a session variable to hold the id of a group wall the user may post on.
        window.location.replace("pages/homepage/homepage.php"); // Trigger a redirect to the homepage HTML.
    }
    else
    {
        alert(data['response']);
    }
}

function signUpSuccess(data)
{
    if (data['outcome'] === 1)
    {
        Session.set('user_id', data['insertId']); // Store the user's id in a session linked to the window.
        Session.set('userWall_id', data['insertId']); // Store the user's id in a session linked to the window.
        Session.set('groupWall_id', ''); // Create a session variable to hold the id of a group wall the user may post on.
        window.location.replace("pages/homepage/homepage.php"); // Trigger a redirect to the homepage HTML.
    }
    else
    {
        alert(data['response']);
    }
}