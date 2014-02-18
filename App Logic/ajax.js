/*
 * This function is responsible for connecting the JavaScript client-side to the PHP server-side.
 */
function ajax(file, params, successCallback)
{
    $.ajax
    (
        {
            type: 'POST',
            url: 'http://localhost/' + file + '.php',
            data: params,
            dataType: 'JSON',
            async: false,
            success: successCallback,
            error: ajaxFailure
        }
    );
}

function ajaxFailure(result) {
    alert("FAILED : " + result.status + ' ' + result.statusText);
}