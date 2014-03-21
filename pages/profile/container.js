function generateContainer()
{
	if (Session.get('userWall_id') !== Session.get('user_id'))
	{
		friendCheck();
	}
	else
	{
		appendPostArea();
		appendFeed();
	}
}

function friendCheck()
{
	ajax(
		'pages/profile/friendCheck',
		{
			'user_id': Session.get('user_id'),
			'friend_id': Session.get('userWall_id')
		},
		friendCheckSuccess
	);
}

function friendCheckSuccess(data)
{
	if (data['outcome'] === 1)
	{
		if (data['response'][0]['countOf'] === "2")
		{
			Session.set('isFriend', '1');
			appendPostArea();
			$("#messageFormText0").attr("placeholder", "Post a message here...");
			appendFeed();
		}
		else if (data['response'][0]['countOf'] === "1")
		{
			Session.set('isFriend', '');
			$(".container").append(
				'<div id="send_friend_request">' +
					'<h4>Friend Request Sent</h4>' +
				'</div>' +
				'<hr style="width:80%; border-color:#C8C8C8;">'
			);
			appendFeed();
		}
		else if (data['response'][0]['countOf'] === "0")
		{
			Session.set('isFriend', '');
			generateFriendRequestLink();
		}
	}
}

function appendPostArea()
{
	$(".container").append(
		'<form class="messageForm" id="messageForm0">' +
            '<textarea class="messageFormText" id="messageFormText0" name="message_string" placeholder="Post a message to your wall here..."></textarea>' +
            '<div class="messageFormLinks">' +
                '<button class="messageFormLink messageFormUploadPictureButton" value="0">Upload a picture</button>' +
                '<span class="messageFormPictureName" id="messageFormPictureName0"></span>' +
                '<input class="messageFormPicture" id="messageFormPicture0" type="file" name="photo_content"></input>' +
                '<button class="messageFormLink messageFormSubmitButton" value="0">Post this!</button>' +
            '</div>' +
        '</form>' +
        '<hr style="width:80%; border-color:#C8C8C8;">'
	);
	generatePostArea();
}

function appendFeed()
{
	$(".container").append(
		'<div id="wall"></div>'
	);
	generateFeed();
}