$(document).ready(function()
{
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
            window.location.reload();
        }
    });

	generateGroupDetails();
	generateContainer();
	generateMemberList();
});