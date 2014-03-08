function newsFeedFunctionality()
{
	ajax(
		'newsFeed',
		{
			'user_id' : Session.get('user_id')
		},
		newsFeedSuccess
	);
}

function newsFeedSuccess(data)
{
	//alert(data['response']);
	/*
	if (data['outcome'] === 1)
    {
        data.forEach(function(element)
		{
			$("#newsFeed").append(
				'<div class="activities">' +
					'<div class="profile_picture">' +
						'<img src="data:image/jpeg;base64,' + element.photoContent + '"/>' +
					'</div>' +
			    	'<div>' +
			    		'<h2>' + element.first_name + ' ' + element.last_name + '</h2>' +
			    	'</div>' +
			    	'<br>' +
			    	'<div>' +
			    		'<img src="data:image/jpeg;base64,' + element.photoContent + '"/>' +
			    	'</div>' +
			    '</div>'
			);
		});
    }
    else
    {
        alert(data['response']);
    }
    */
}