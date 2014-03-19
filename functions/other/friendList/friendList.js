$("document").ready(function()
{

        ajax(
            'friendList',                       // PHP file to call on.
            {user_id: Session.get('user_id')},  // User_id from session goes here
            readListSuccess                     // Callback method to use on success.
        );

});

function readListSuccess(data)
{

        data.forEach(function(element){
            $("#photo").append('<div>'+ 
                                '<div>'+ '<h2>' + element.first_name+' '+element.last_name + '</h2>' + '</div>' +
                                '<br>' + 
                                '<div>' + '<img src="data:image/jpeg;base64,'+ element.photoContent + '" />'+ '</div>' +
                            '</div>'
                            )
        })
}