function generateMemberList()
{
	ajax(
		'pages/groups/memberList',
		{
			'groups_id': Session.get('groupWall_id')
		},
		memberListSuccess
	);
}

function memberListSuccess(data)
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

			$("#member_list").append(
				'<li class="list-group-item member_list_item">' +
					'<div class="panel panel-default member_picture_container">' +
						'<img class="member_picture_image" src="data:image/jpeg;base64,' + element['member_picture'] + '"/>' +
					'</div>' +
					'<a class="entity member_name" href="user,' + element['member_id'] + '">' + name + '</a>' +
				'</li>'
			);
		});
	}
}