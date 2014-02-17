/*
 * This function is responsible for connecting the JavaScript client-side to the PHP server-side.
 */
function ajax(sqlParams, dataParams, successCallback, failureCallback)
{
    $.ajax
    (
        {
            type: 'POST',
            url: 'http://localhost/query.php',
            data:
            {
                sqlParams : sqlParams,
                dataParams : dataParams
            },
            dataType:'JSON',
            success: function(data)
            {
                successCallback(data);
            },
            error: function(transaction, err)
            {
                failureCallback("Error: " + err.message);
            }
        }
    );
}