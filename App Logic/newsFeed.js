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
        data['response'].forEach(function(element)
		{
            // Append the message's sender photo and details.
            $("#newsFeed").append(
                '<div class="post">' +
                    '<div class="postContents">' +
                        '<div class="senderPictureContainer"><img src="data:image/jpeg;base64,' + element['sender_photo'] + '" class="senderPicture"/></div>' +
                        '<div class="messageContents">' +
                            '<div class="fromToDetails">' +
                                '<div class="senderName"><a href="#" class="entityName">' + element['sender_fname'] + ' ' + element['sender_mname'] + ' ' + element['sender_lname'] + '</a></div>' +
                                (element['recipient_id'] === Session.get('user_id')
                                    ? '<div class="to">posted on your wall</div><div class="recipientName"><a href="#" class="entityName"></a></div>'
                                    : (element['recipient_id'] !== null
                                        ? '<div class="to">➡</div><div class="recipientName"><a href="#" class="entityName">' + element['recipient_fname'] + ' ' + element['recipient_mname'] + ' ' + element['recipient_lname'] + '</a></div>'
                                        : (element['group_id'] !== null
                                            ? '<div class="to">posted on group</div><div class="recipientName"><a href="#" class="entityName">' + element['group_name'] + '</a></div>'
                                            : ''
                                        )
                                    )
                                ) +
                            '</div>' +
                            (element['message_string'] !== ''
                                ? '<div class="messageString">' + element['message_string'] + '</div>'
                                : ''
                            ) +
                            (element['uploaded_photo'] !== ''
                                ? '<div class="uploadedPictureContainer"><img src="data:image/jpeg;base64,' + element['uploaded_photo'] + '" class="uploadedPicture"/></div>'
                                : ''
                            ) +
                            '<div class="timestamp">' + element['timestamp'] + '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            );
		});
    }
    else
    {
        alert(data['response']);
    }
}