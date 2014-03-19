$(document).ready(function()
{
	if (Session.get('userWall_id') !== Session.get('user_id'))
	{
		$("#messageFormText0").attr("placeholder", "Post a message here...");
	}
	generatePostArea();
	generateFeed();
});