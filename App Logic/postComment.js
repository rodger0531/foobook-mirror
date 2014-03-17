function postWallFunctionality()
{
    var intervalFunc = function ()
    {
        $("#postWallPictureName").html($("#postWallPicture").val());
    };

    $(".postWallUploadPictureButton").bind("click", function(event)
    {
        event.preventDefault();
        $("#postWallPicture").click();
        setInterval(intervalFunc, 1);
    });

    $(".postWallSubmitButton").on('click', function(event)
    {
        event.preventDefault();
        if (($("#postWallMessage").val() === "") && ($("#postWallPicture").val()) === "")
        {
            alert("You need to enter a message and/or upload an image before posting!");
        }
        else
        {
            var formData = new FormData($("#postWallForm")[0]);
            formData.append("user_id", Session.get("user_id"));
            formData.append("userWall_id", Session.get("userWall_id"));
            formData.append("groupWall_id", Session.get("groupWall_id"));
            $.ajax(
            {
                type: 'POST',
                url: 'http://localhost/postWall.php',
                data: formData,
                dataType: 'JSON',
                success: postSuccess,
                error: ajaxFailure,
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
}

function postSuccess(data)
{
    location.reload();
}