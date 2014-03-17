function newsfeedFunctionality()
{
    generatePosts();
}

function generatePosts()
{
	ajax(
		'newsfeedPosts',
		{
			'user_id' : Session.get('user_id')
		},
		generatePostsSuccess
	);
}

function generatePostsSuccess(data)
{
	if (data['outcome'] === 1)
    {
    	$("#newsfeed").html("");

        var messageContents = "";

        data['response'].forEach(function(element)
		{
            messageContents =
                '<div class="message_details">' +
                    '<div class="message_sender_picture_container">' +
                        '<img class="message_sender_picture" src="data:image/jpeg;base64,' + element['sender_picture'] + '"/>' +
                    '</div>' +
                    '<div class="message_from_to_details">' +
                        '<div class="message_sender_name"><a class="entity" href="#">' + element['sender_fname'] + ' ' + element['sender_mname'] + ' ' + element['sender_lname'] + '</a></div>' +
                        (element['recipient_id'] === Session.get('user_id')
                            ? '<div class="message_to">posted on your wall</div><div class="message_recipient_name"><a class="entity" href="#"></a></div>'
                            : (element['recipient_id'] !== null
                                ? '<div class="message_to">➡</div><div class="message_recipient_name"><a class="entity" href="#">' + element['recipient_fname'] + ' ' + element['recipient_mname'] + ' ' + element['recipient_lname'] + '</a></div>'
                                : (element['group_id'] !== null
                                    ? '<div class="message_to">posted on group</div><div class="message_recipient_name"><a class="entity" href="#">' + element['group_name'] + '</a></div>'
                                    : ''
                                )
                            )
                        ) +
                        '<div>' + element['timestamp'] + '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="message_content">' +
                    '<hr>' +
                    (element['message_string'] !== ''
                        ? '<div class="message_string">' + element['message_string'] + '</div>'
                        : ''
                    ) +
                    (element['uploaded_picture'] !== ''
                        ? '<hr><div class="message_uploaded_picture_container"><img class="message_uploaded_picture" src="data:image/jpeg;base64,' + element['uploaded_picture'] + '"/></div>'
                        : ''
                    ) +
                '</div>';

            $("#newsfeed").append(
                '<div class="message">' + messageContents + '</div>' +
                '<div id="comment_on_post_id_' + element['message_id'] + '"></div>'
            );
            
            generateComments(element['message_id']);
            
            $("#newsfeed").append(
                '<form class="commentForm" id="messageForm' + element['message_id'] + '">' +
                    '<textarea class="commentFormText" id="messageFormText' + element['message_id'] + '" name="message_string" placeholder="Post a comment here..."></textarea>' +
                    '<div class="messageFormLinks">' +
                        '<button class="messageFormLink messageFormUploadPictureButton" value="' + element['message_id'] + '">Upload a picture</button>' +
                        '<span class="messageFormPictureName" id="messageFormPictureName' + element['message_id'] + '"></span>' +
                        '<input class="messageFormPicture" id="messageFormPicture' + element['message_id'] + '" type="file" name="photo_content"></input>' +
                        '<button class="messageFormLink messageFormSubmitButton" value="' + element['message_id'] + '">Post this!</button>' +
                    '</div>' +
                '</form>'
            );
		});
    }
}

function generateComments(message_id)
{
    ajax(
        'newsfeedComments',
        {
            'message_id' : message_id
        },
        generateCommentsSuccess
    );
}

function generateCommentsSuccess(data)
{
    if (data['outcome'] === 1)
    {
        var messageContents = "";

        data['response'].forEach(function(element)
        {
            messageContents =
                '<div class="message_details">' +
                    '<div class="comment_sender_picture_container">' +
                        '<img class="comment_sender_picture" src="data:image/jpeg;base64,' + element['sender_picture'] + '"/>' +
                    '</div>' +
                    '<div class="comment_from_to_details">' +
                        '<div class="comment_sender_name"><a class="entity" href="#">' + element['sender_fname'] + ' ' + element['sender_mname'] + ' ' + element['sender_lname'] + '</a></div>' +
                        '<br><div class="comment_timestamp">' + element['timestamp'] + '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="message_content">' +
                    '<hr>' +
                    (element['message_string'] !== ''
                        ? '<div class="message_string">' + element['message_string'] + '</div>'
                        : ''
                    ) +
                    (element['uploaded_picture'] !== ''
                        ? '<hr><div class="message_uploaded_picture_container"><img class="message_uploaded_picture" src="data:image/jpeg;base64,' + element['uploaded_picture'] + '"/></div>'
                        : ''
                    ) +
                '</div>';

            $("#comment_on_post_id_" + element['comment_on_post_id']).append(
                '<div class="comment">' + messageContents + '</div>'
            );
        });
    }
}