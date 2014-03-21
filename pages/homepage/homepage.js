$(document).ready(function()
{
	Session.set('user_id', '1');
	Session.set('userWall_id', '1');
	Session.set('groupWall_id', '');

	$("body").on('click', ".entity", function(event)
    {
        event.preventDefault();
        var entity_id = this.getAttribute("href").split(",");
        if (entity_id[0] === "user")
        {
            Session.set('userWall_id', entity_id[1]);
            window.location.replace("../profile/profile.php");
        }
        else if (entity_id[0] === "group")
        {
            Session.set('groupWall_id', entity_id[1]);
            window.location.replace("../groups/groups.php");
        }
    });

	generatePostArea();
	generateFeed();
});