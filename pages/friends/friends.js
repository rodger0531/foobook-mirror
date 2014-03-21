$("document").ready(function()
{
    Session.set('user_id',1);
    ajax(
        'pages/friends/friendList',                       // PHP file to call on.
        {user_id: Session.get('user_id')},  // User_id from session goes here
        readFriendSuccess                     // Callback method to use on success.
    );

    ajax(
        'pages/friends/viewCircle',                       // PHP file to call on.
        {user_id: Session.get('user_id')},  // User_id from session goes here
        readCircleSuccess                     // Callback method to use on success.
    );

    $("#friendslist").on("click",(".lists"),function(){
        Session.set('userWall_id',this.getAttribute("value"));
        window.location.assign("../profile/profile.php");
    });




    $("#addCircle").on('submit', function(event)
    {
        event.preventDefault();
        ajax(
            'pages/friends/createCircle',                        // PHP file to call on.
            {owner_id: Session.get('user_id'),circle_name:document.forms["addCircle"]["circle_name"].value},    // Data from serialised form with user input.
            function success(){alert("Add circle successfully")
            location.reload();}                         // Callback method to use on success.
        );
    });

    $("#addFriendToCircle").on('submit', function(event)
        {
            event.preventDefault();
            ajax(
                'pages/friends/addFriendToCircle',                        // PHP file to call on.
                {friend_id:document.forms["addFriendToCircle"]["friend_id"].value,circle_id: $("#addFriendToCircle").val()},    // Data from serialised form with user input.
                function success(data){
                    loadList($("#addFriendToCircle").val());
                }                         // Callback method to use on success.
            );
        });

    $("#deleteCircle").on('click',function(){
        ajax(
            'pages/friends/removeCircle',                        // PHP file to call on.
            {circle_id: $("#circleList").val()},    // Data from serialised form with user input.
            function success(){
                alert("Deleted circle successfully");
                location.reload();
            }                         // Callback method to use on success.
        );
    });

})