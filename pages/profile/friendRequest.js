function generateFriendRequestLink()
{
	$(".container").on('click', "#send_friend_request_link", function(event)
    {
        event.preventDefault();

        ajax(
			'pages/profile/sendFriendRequest',
			{
				'user_id': Session.get('user_id'),
				'friend_id': Session.get('userWall_id')
			},
			sendFriendRequestSuccess
		);
    });

	$(".container").append(
		'<div id="send_friend_request">' +
			'<a id="send_friend_request_link" href="#">Send Friend Request</a>' +
		'</div>' +
		'<hr style="width:80%; border-color:#C8C8C8;">'
	);

	appendFeed();
}

function sendFriendRequestSuccess()
{
	$("#send_friend_request").html("<h4>Friend Request Sent</h4>");
}