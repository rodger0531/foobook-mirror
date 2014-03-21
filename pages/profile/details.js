function generateProfileDetails()
{
	ajax(
		'pages/profile/details',
		{
			'user_id': Session.get('userWall_id'),
		},
		detailsSuccess
	);
}

function detailsSuccess(data)
{
	if (data['outcome'] === 1)
	{
		var element = data['response'][0];

		var name = element['first_name'] + " " +
			((element['middle_name'] !== ("" || null))
				? element['middle_name'] + " "
                : "") +
			element['last_name'];
		$("#profile_name").html(name);

		$("#profile_picture_container").html(
			'<img id="profile_picture_image" src="data:image/jpeg;base64,' + element['profile_picture'] + '"/>'
		);

		$("#profile_details").html(
			'<li class="list-group-item">Date of birth: ' + element['date_of_birth'] + '</li>' +
			((element['school_name'] !== ("" || null))
                ? '<li class="list-group-item">Attended: ' + element['school_name'] + '</li>'
                : "") +
			((element['employer_name'] !== ("" || null))
                ? '<li class="list-group-item">Works at: ' + element['employer_name'] + '</li>'
                : "")
		);
	}
}