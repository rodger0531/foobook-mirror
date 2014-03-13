$("document").ready(function()
{
    Session.set('user_id',1);
    ajax(
        'viewCircle',                       // PHP file to call on.
        {user_id: Session.get('user_id')},  // User_id from session goes here
        readListSuccess                     // Callback method to use on success.
    );

    $("#addCircle").on('submit', function(event)
    {
        event.preventDefault();
        ajax(
            'createCircle',                        // PHP file to call on.
            {owner_id: Session.get('user_id'),circle_name:document.forms["addCircle"]["circle_name"].value},    // Data from serialised form with user input.
            function success(){alert("Add circle successfully")
            location.reload();}                         // Callback method to use on success.
        );
    });

    $("#addFriendToCircle").on('submit', function(event)
        {
            event.preventDefault();
            ajax(
                'addFriendToCircle',                        // PHP file to call on.
                {friend_id:document.forms["addFriendToCircle"]["friend_id"].value,circle_id: $("#circleList").val()},    // Data from serialised form with user input.
                function success(data){
                    alert("Added friend into circle successfully");
                    loadList($("#circleList").val());
                }                         // Callback method to use on success.
            );
        });

    $("#circleList").on('change',function(){
        loadList($(this).val());
    });

    $("#deleteCircle").on('click',function(){
        ajax(
            'removeCircle',                        // PHP file to call on.
            {circle_id: $("#circleList").val()},    // Data from serialised form with user input.
            function success(){
                alert("Deleted circle successfully");
                location.reload();
            }                         // Callback method to use on success.
        );
    });

    $("#friendList").on("click",".circleFriend",function(){
        ajax(
            'removeFriendFromCircle',                        // PHP file to call on.
            {friend_id:$(this).val(),circle_id: $("#circleList").val()},    // Data from serialised form with user input.
            function success(){
                alert("Removed friend from circle successfully");
                loadList($("#circleList").val());
            }                         // Callback method to use on success.
        );
    });

});

function readListSuccess(data)
{
    $("#circleList").append('<option value = NULL > Select a circle </option>')
    data.forEach(function(element){
        $("#circleList").append('<option value ='+element.circle_id+'>'+element.circle_name+'</option>')
    })
}



function loadList(circle_id){
    if (circle_id!=="NULL"){
        ajax(
            'viewCircleFriend',                       // PHP file to call on.
            {circle_id: circle_id},  // User_id from session goes here
            loadListSuccess                    // Callback method to use on success.
        );
    }
        
}

function loadListSuccess(friends){
    $("#friendList").html("");
    if (friends['outcome']===1){
        // $("#friendList").append();
        friends['response'].forEach(function(element){
            $("#friendList").append('<button type="button" value='+element.user_id+' class="circleFriend">DELETE</button>'+element.first_name + ' ' + element.last_name+'</br>');
        })
    }else{
        $("#friendList").html("");
    }
}