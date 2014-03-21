function generateGroupDetails()
{
	ajax(
		'pages/groups/details',
		{
			'groups_id': Session.get('groupWall_id'),
		},
		detailsSuccess
	);
}

function detailsSuccess(data)
{
	if (data['outcome'] === 1)
	{
		var element = data['response'][0];

		$("#group_name").html(element['groups_name']);
	}
}