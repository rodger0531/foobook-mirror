$(document).ready(function()
{

	$('.edit-account-info').hide();

	loadUserInfo();

	$('.account-info').on('click', '#edit', function()
	{
		$('.account-info').hide();
		$('.edit-account-info').show();
	});

	$('.edit-account-info').on('click', '#edit-done', function()
	{
		if($('#edit-email').val() === "")
		{
			alert('Please enter an email');
		}
		else
		{
			var first_name = $('#first-name').val();
			var middle_name = $('#middle-name').val();
			var last_name = $('#last-name').val();
			var email = $('#edit-email').val();
			var password = $('#edit-password').val();
			var city = $('#edit-city').val();
			var country = $('#edit-country').val();
			var school_name = $('#edit-school-name').val();
			var employer_name = $('#edit-employer-name').val();

			ajax(
				'/pages/settings/updateUserInfo',
				{
					'user_id' : Session.get('user_id'),
					'first_name' : first_name,
					'middle_name' : middle_name,
					'last_name' : last_name,
					'email' : email,
					'password' : password,
					'city' : city,
					'country' : country,
					'school_name' : school_name,
					'employer_name' : employer_name

				},
				updateUserInfoSuccess
			);

			$('.account-info').show();
			$('.edit-account-info').hide();
		}
		
	});
});

function loadUserInfo()
{
	ajax(
		'pages/settings/loadUserInfo',
		{'user_id' : Session.get('user_id')},
		loadUserInfoSuccess
	);
}

function loadUserInfoSuccess(data)
{
	if(data.outcome !== 0)
	{ 
		$('.account-info').html(	'<label class="account-settings"><h2>Account Settings</h2></label>'+
					                '<div>' +
					                    '<a id="edit">Edit</a>' +
					                '</div>' +

                					'<hr class="separator">' +

					                '<div class="user-name">' +
					                    '<label id="name-label"><strong>Name</strong></label>' +
					                    '<span id="full-name">'+ data[0].first_name +' '+ data[0].middle_name +' '+ data[0].last_name +'</span>' +
					                '</div>' +

					                '<hr class="inner-separator">' +

					                '<div class="user-email">' +
					                    '<label id="email-label"><strong>Email</strong></label>' +
					                    '<span id="email">'+ data[0].email +'</span>' +
					                '</div>' +

					                '<hr class="inner-separator">' +

					                '<div class="user-password">' +
					                    '<label id="password-label"><strong>Password</strong></label>' +
					                    '<span id="password">**************</span>' +
					                '</div>' +

					                '<hr class="inner-separator">' +

					                '<div class="user-city">' +
					                    '<label id="city-label"><strong>City</strong></label>' +
					                    '<span id="city">'+ data[0].city +'</span>' +
					                '</div>' +

					                '<hr class="inner-separator">' +

					                '<div class="user-country">' +
					                    '<label id="country-label"><strong>Country</strong></label>' +
					                    '<span id="country">'+ data[0].country +'</span>' +
					                '</div>' +

					                '<hr class="inner-separator">' +

					                '<div class="user-school">' +
					                    '<label id="school-label"><strong>School</strong></label>' +
					                    '<span id="school-name">'+ ((data[0].school_name !== ("" || null)) ? data[0].school_name : "<span>No school enter</span>") +'</span>' +
					                '</div>' +

					                '<hr class="inner-separator">' +

					                '<div class="user-employer">' +
					                    '<label id="employer-label"><strong>Job</strong></label>' +
					                    '<span id="employer-name">'+ ((data[0].employer_name !== ("" || null)) ? data[0].employer_name : "<span>No job enter</span>") +'</span>' +
					                '</div>' +

					                '<hr class="separator">' 
			);

		$('.edit-account-info').html(		'<label class="account-settings"><h2>Account Settings</h2></label>' +
                							'<button class="btn btn-primary" id="edit-done">Done</button>' +

											'<hr class="separator">' +

							                '<div class="user-name">' +
							                    '<label id="name-label"><strong>Name</strong></label>' +
							                    '<input class="form-control" id="first-name" value="'+ data[0].first_name +'" placeholder="First name">' +
							                    '<input class="form-control" id="middle-name" value="'+ data[0].middle_name +'" placeholder="Optional">' +
							                    '<input class="form-control" id="last-name" value="'+ data[0].last_name +'" placeholder="Last name">' +
							                '</div>' +

							                '<hr class="inner-separator">' +

							                '<div class="user-email">' +
							                    '<label id="email-label"><strong>Email</strong></label>' +
							                    '<input class="form-control" id="edit-email" value="'+ data[0].email +'" placeholder="Email">' +
							                '</div>' +

							                '<hr class="inner-separator">' +

							                '<div class="user-password">' +
							                    '<label id="password-label"><strong>Password</strong></label>' +
							                    '<input class="form-control" id="edit-password" value"" placeholder="New password">' +
							                '</div>' +

							                '<hr class="inner-separator">' +

							                '<div class="user-city">' +
							                    '<label id="city-label"><strong>City</strong></label>' +
							                    '<input class="form-control" id="edit-city" value="'+ data[0].city +'" placeholder="City">' +
							                '</div>' +

							                '<hr class="inner-separator">' +

							                '<div class="user-country">' +
							                    '<label id="country-label"><strong>Country</strong></label>' +
							                    '<input class="form-control" id="edit-country" value="'+ data[0].country +'" placeholder="country">' +
							                '</div>' +

							                '<hr class="inner-separator">' +

							                '<div class="user-school">' +
							                    '<label id="school-label"><strong>School</strong></label>' +
							                    '<input class="form-control" id="edit-school-name" value="'+ ((data[0].school_name !== ("" || null)) ? data[0].school_name : "") +'" placeholder="school">' +
							                '</div>' +

							                '<hr class="inner-separator">' +

							                '<div class="user-employer">' +
							                    '<label id="employer-label"><strong>Job</strong></label>' +
							                    '<input class="form-control" id="edit-employer-name" value="'+ ((data[0].employer_name !== ("" || null)) ? data[0].employer_name : "") +'" placeholder="employer">' +
							                '</div>' +

							                '<hr class="separator">'
			);
	}
}

function updateUserInfoSuccess(data)
{
	if(data.outcome !== 0)
	{
		loadUserInfo();
		$('.edit-account-info').hide();

	}
}