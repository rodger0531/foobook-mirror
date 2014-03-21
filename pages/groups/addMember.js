function generateJoinGroupLink()
{
	$(".container").on('click', "#join_group_link", function(event)
    {
        event.preventDefault();

        ajax(
			'pages/groups/addMember',
			{
				'user_id': Session.get('user_id'),
				'groups_id': Session.get('groupWall_id')
			},
			joinGroupSuccess
		);
    });

	$(".container").append(
		'<div id="join_group">' +
			'<a id="join_group_link" href="#">Join Group</a>' +
		'</div>' +
		'<hr style="width:80%; border-color:#C8C8C8;">'
	);

	appendFeed();
}

function joinGroupSuccess()
{
	$("#join_group").html("<h4>Joined Group</h4>");
}