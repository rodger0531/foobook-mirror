$("document").ready(function()
{
    $("#photoUploadForm").on('submit', function(event)
    {
        event.preventDefault();
        var formData = new FormData($("#photoUploadForm")[0]);
        $.ajax(
        {
            type: 'POST',
            url: 'http://localhost/uploadPhoto.php',
            data: formData,
            dataType: 'JSON',
            success: uploadSuccess,
            error: ajaxFailure,
            cache: false,
            contentType: false,
            processData: false
        });
    })
});

function uploadSuccess(data)
{
    alert(data);
}