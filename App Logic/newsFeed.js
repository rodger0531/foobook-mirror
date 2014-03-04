$(window).load(function()
{
	ajax(
		'newsFeed',									// PHP file to call on.
		{
			'user_id' : Session.get('user_id')		// Data needed.
		},
		newsFeedSuccess								// Callback method to use on success.
	);
});

function newsFeedSuccess(data)
{
	//alert(data);
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