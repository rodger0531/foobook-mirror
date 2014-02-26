$("document").ready(function()
{
    $("#photoViewForm").on('submit', function(event)
    {
        event.preventDefault();
        ajax(
            'viewPhoto',                        // PHP file to call on.
            $("#photoViewForm").serialize(),    // Data from serialised form with user input.
            viewSuccess                         // Callback method to use on success.
        );
    });
});

function viewSuccess(data)
{
    $("#photoDesc").html(data[0].description);
    $("#photoSrc").html('<img src="data:image/jpeg;base64,' + data[0].photoContent + '" />');
}