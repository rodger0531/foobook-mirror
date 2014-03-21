function generateContainer()
{
	memberCheck();
}

function memberCheck()
{
	ajax(
		'pages/groups/memberCheck',
		{
			'user_id': Session.get('user_id'),
			'groups_id': Session.get('groupWall_id')
		},
		memberCheckSuccess
	);
}

function memberCheckSuccess(data)
{
	if (data['outcome'] === 1)
	{
		if (data['response'][0]['countOf'] === "1")
		{
			Session.set('isMember', '1');
			appendPostArea();
		}
		else if (data['response'][0]['countOf'] === "0")
		{
			Session.set('isMember', '');
			generateJoinGroupLink();
		}
		appendFeed();
	}
}

function appendPostArea()
{
	$(".container").append(
		'<form class="messageForm" id="messageForm0">' +
            '<textarea class="messageFormText" id="messageFormText0" name="message_string" placeholder="Post a message here..."></textarea>' +
            '<div class="messageFormLinks">' +
                '<button class="messageFormLink messageFormUploadPictureButton btn btn-primary" value="0">Upload a picture</button>' +
                '<span class="messageFormPictureName" id="messageFormPictureName0"></span>' +
                '<input class="messageFormPicture" id="messageFormPicture0" type="file" name="photo_content"></input>' +
                '<button class="messageFormLink messageFormSubmitButton btn btn-success" value="0">Post this!</button>' +
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