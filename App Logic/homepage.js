$(document).ready(function()
{
	Session.set('user_id', '1');
	Session.set('userWall_id', '1');
	Session.set('groupWall_id', '');

	//searchFunctionality();
	post();
	newsfeed();
});