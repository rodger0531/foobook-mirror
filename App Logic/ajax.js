/*
 * This function is responsible for connecting the JavaScript client-side to the PHP server-side.
 */
function ajax(file, params, successCallback, failureCallback)
{
    $.ajax
    (
        {
            type: 'POST',
            url: 'http://localhost/' + file + '.php',
            data: params,
            dataType: 'JSON',
            success: function(data)
            {
                successCallback(data);
            },
            error: function(error)
            {
                failureCallback(error);
            }
        }
    );
}