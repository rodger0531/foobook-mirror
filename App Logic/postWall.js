function postWallFunctionality()
{
    $(".messageFormUploadPictureButton").bind("click", function(event)
    {
        event.preventDefault();
        alert("check");
        Session.set('temp_click_id', this.value);
        $("#messageFormPicture" + this.value).click();
        setInterval(
            function()
            {
                setMessageFormPictureName(Session.get('temp_click_id'));
            }, 1
        );
        
    });

    $(".messageFormSubmitButton").on('click', function(event)
    {
        event.preventDefault();
        if (($("#messageFormText" + this.value).val() === "") && ($("#messageFormPicture" + this.value).val()) === "")
        {
            alert("You need to enter a message and/or upload an image before posting!");
        }
        else
        {
            var formData = new FormData($("#messageForm" + this.value)[0]);
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

function setMessageFormPictureName(messageValue)
{
    $("#messageFormPictureName" + messageValue).html($("#messageFormPicture" + messageValue).val());
}

function postSuccess(data)
{
    location.reload();
}