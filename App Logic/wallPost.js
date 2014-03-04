$(window).load(function()
{
    var intervalFunc = function ()
    {
        $("#photoName").html($("#photoFile").val());
    };

    $("#uploadPhoto").bind("click", function(event)
    {
        event.preventDefault();
        $("#photoFile").click();
        setInterval(intervalFunc, 1);
    });

	$("#postThis").on('click', function(event)
    {
        event.preventDefault();
        var formData = new FormData($("#wallPostForm")[0]);
        formData.append("user_id", Session.get("user_id"));
        formData.append("userWall_id", Session.get("userWall_id"));
        formData.append("groupWall_id", Session.get("groupWall_id"));
        $.ajax(
        {
            type: 'POST',
            url: 'http://localhost/wallPost.php',
            data: formData,
            dataType: 'JSON',
            success: postSuccess,
            error: ajaxFailure,
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

function postSuccess(data)
{
    location.reload();
}