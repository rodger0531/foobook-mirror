function post()
{
    $(".container").on('click', ".messageFormUploadPictureButton", function(event)
    {
        event.preventDefault();
        Session.set('temp_click_id', this.value);
        $("#messageFormPicture" + this.value).click();
        setInterval(
            function()
            {
                setMessageFormPictureName(Session.get('temp_click_id'));
            }, 1
        );
    });

    $(".container").on('click', ".messageFormSubmitButton", function(event)
    {
        event.preventDefault();
        if (($("#messageFormText" + this.value).val() === "") && ($("#messageFormPicture" + this.value).val()) === "")
        {
            alert("You need to enter a message and/or upload an image before posting!");
        }
        else
        {
            var user_id = Session.get("user_id");
            if (this.value === "0")
            {
                if (Session.get("userWall_id") !== "")
                {
                    var userWall_id = Session.get("userWall_id");
                    var groupWall_id = null;
                }
                else if (Session.get("groupWall_id") !== "")
                {
                    var userWall_id = null;
                    var groupWall_id = Session.get("groupWall_id");
                }
                var comment_on_post_id = null;
            }
            else
            {
                var userWall_id = null;
                var groupWall_id = null;
                var comment_on_post_id = this.value;
            }
            var formData = new FormData($("#messageForm" + this.value)[0]);
            formData.append("user_id", user_id);
            formData.append("userWall_id", userWall_id);
            formData.append("groupWall_id", groupWall_id);
            formData.append("comment_on_post_id", comment_on_post_id);
            $.ajax(
            {
                type: 'POST',
                url: 'http://localhost/post.php',
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