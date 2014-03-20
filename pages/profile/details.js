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

		$("#profile_text_details").html(
			'<div>Date of birth: ' + element['date_of_birth'] + '</div>' +
			((element['school_name'] !== ("" || null))
                ? '<div>Attended: ' + element['school_name'] + '</div>'
                : "") +
			((element['employer_name'] !== ("" || null))
                ? '<div>Works at: ' + element['employer_name'] + '</div>'
                : "")
		);
	}
}