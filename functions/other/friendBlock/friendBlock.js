$("document").ready(function()
{
    Session.set('user_id',1);
    ajax(
        'viewFriendBlock',                       // PHP file to call on.
        {user_id: Session.get('user_id')},  // User_id from session goes here
        readListSuccess                     // Callback method to use on success.
    );

    $("#blockFriend").on('submit', function(event)
    {
        event.preventDefault();
        ajax(
            'addBlockList',                        // PHP file to call on.
            {user_id: Session.get('user_id'),block_id:document.forms["blockFriend"]["block_id"].value},    // Data from serialised form with user input.
            function success(){alert("success")}                         // Callback method to use on success.
        );
    });

    $("#removeBlockFriend").on('submit', function(event)
    {
        event.preventDefault();
        ajax(
            'removeBlockList',                        // PHP file to call on.
            {user_id: Session.get('user_id'),block_id:document.forms["removeBlockFriend"]["removeBlock_id"].value},    // Data from serialised form with user input.
            function success(){alert("success")}                         // Callback method to use on success.
        );
    });

});

function readListSuccess(data)
{

        data.forEach(function(element){
            $("#list").append('<div>'+ 
                                '<div>'+ '<h3>' + element.first_name+' '+element.last_name + '</h3>' + '</div>' +
                                '<br>' + 
                            '</div>'
                            )
        })
}