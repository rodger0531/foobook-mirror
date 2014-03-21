function generateFriendList()
{
	ajax(
		'pages/profile/friendList',
		{
			'user_id': Session.get('userWall_id')
		},
		friendListSuccess
	);
}

function friendListSuccess(data)
{
	if (data['outcome'] === 1)
	{
		data['response'].forEach(function(element)
		{
			var name = element['first_name'] + " " +
				((element['middle_name'] !== ("" || null))
					? element['middle_name'] + " "
	                : "") +
				element['last_name'];

			$("#friend_list").append(
				'<li class="list-group-item friend_list_item">' +
					'<div class="panel panel-default friend_picture_container">' +
						'<img class="friend_picture_image" src="data:image/jpeg;base64,' + element['friend_picture'] + '"/>' +
					'</div>' +
					'<a class="entity friend_name" href="user,' + element['friend_id'] + '">' + name + '</a>' +
				'</li>'
			);
		});
	}
}