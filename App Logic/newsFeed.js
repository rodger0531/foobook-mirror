function newsFeedFunctionality()
{
	ajax(
		'newsFeed',
		{
			'user_id' : Session.get('user_id')
		},
		newsFeedSuccess
	);
}

function newsFeedSuccess(data)
{
	if (data['outcome'] === 1)
    {
    	$("#newsFeed").html("");

        var messageContents = "";

        data['response'].forEach(function(element)
		{
            messageContents =
                '<div class="details">' +
                    '<div class="sender_picture_container">' +
                        '<img src="data:image/jpeg;base64,' + element['sender_picture'] + '" class="sender_picture"/>' +
                    '</div>' +
                    '<div class="from_to_details">' +
                        '<div class="sender_name"><a href="#" class="entity">' + element['sender_fname'] + ' ' + element['sender_mname'] + ' ' + element['sender_lname'] + '</a></div>' +
                        (element['recipient_id'] === Session.get('user_id')
                            ? '<div class="to">posted on your wall</div><div class="recipient_name"><a href="#" class="entity"></a></div>'
                            : (element['recipient_id'] !== null
                                ? '<div class="to">➡</div><div class="recipient_name"><a href="#" class="entity">' + element['recipient_fname'] + ' ' + element['recipient_mname'] + ' ' + element['recipient_lname'] + '</a></div>'
                                : (element['group_id'] !== null
                                    ? '<div class="to">posted on group</div><div class="recipient_name"><a href="#" class="entity">' + element['group_name'] + '</a></div>'
                                    : ''
                                )
                            )
                        ) +
                        '<div class="timestamp">' + element['timestamp'] + '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="content">' +
                    '<hr>' +
                    (element['message_string'] !== ''
                        ? '<div class="message_string">' + element['message_string'] + '</div>'
                        : ''
                    ) +
                    (element['uploaded_picture'] !== ''
                        ? '<hr><div class="uploaded_picture_container"><img src="data:image/jpeg;base64,' + element['uploaded_picture'] + '" class="uploaded_picture"/></div>'
                        : ''
                    ) +
                '</div>'

            $("#newsFeed").append(
                '<div class="post">' + messageContents + '</div>'
            )
		});
    }
    else
    {
        alert(data['response']);
    }
}