function generateFeed()
{
    $("#wall").on('click', ".entity", function(event)
    {
        event.preventDefault();
        var entity_id = this.getAttribute("href").split(",");
        if (entity_id[0] === "user")
        {
            Session.set('userWall_id', entity_id[1]);
            window.location.replace("../profile/profile.php");
        }
        else if (entity_id[0] === "group")
        {
            Session.set('groupWall_id', entity_id[1]);
            window.location.reload();
        }
    });

    generatePosts();
}

function generatePosts()
{
	ajax(
		'pages/groups/wallPosts',
		{
			'groups_id': Session.get('groupWall_id')
		},
		generatePostsSuccess
	);
}

function generatePostsSuccess(data)
{
    alert(data['outcome']);
	if (data['outcome'] === 1)
    {
    	$("#wall").html("");

        var messageContents = "";

        data['response'].forEach(function(element)
		{
            messageContents =
                '<div class="message_details">' +
                    '<div class="message_sender_picture_container">' +
                        '<img class="message_sender_picture" src="data:image/jpeg;base64,' + element['sender_picture'] + '"/>' +
                    '</div>' +
                    '<div class="message_from_to_details">' +
                        '<div class="message_sender_name"><a class="entity" href="user,' + element['sender_id'] + '">' + element['sender_fname'] + ' ' + element['sender_mname'] + ' ' + element['sender_lname'] + '</a></div>' +
                        '<br><div class="message_timestamp">' + element['created'] + '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="message_content">' +
                    (element['message_string'] !== ''
                        ? '<hr><div class="message_string">' + element['message_string'] + '</div>'
                        : ''
                    ) +
                    (element['uploaded_picture'] !== ''
                        ? '<hr><div class="message_uploaded_picture_container"><img class="message_uploaded_picture" src="data:image/jpeg;base64,' + element['uploaded_picture'] + '"/></div>'
                        : ''
                    ) +
                '</div>';

            $("#wall").append(
                '<div class="message">' + messageContents + '</div>' +
                '<div id="comment_on_post_id_' + element['message_id'] + '"></div>'
            );
            
            generateComments(element['message_id']);
            
            $("#wall").append(
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
    else if (data['outcome'] === 0)
    {
        if (data['response'] === 202)
        {
            if ($("#wall").html() === "")
            {
                $("#wall").append(
                    '<h4 class="empty_feed_message">No posts to display.</h4>'
                );
            }
        }
    }
}

function generateComments(message_id)
{
    ajax(
        'pages/groups/wallComments',
        {
            'message_id': message_id
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
                        '<div class="comment_sender_name"><a class="entity" href="user,' + element['sender_id'] + '">' + element['sender_fname'] + ' ' + element['sender_mname'] + ' ' + element['sender_lname'] + '</a></div>' +
                        '<br><div class="comment_timestamp">' + element['created'] + '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="message_content">' +
                    (element['message_string'] !== ''
                        ? '<hr><div class="message_string">' + element['message_string'] + '</div>'
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