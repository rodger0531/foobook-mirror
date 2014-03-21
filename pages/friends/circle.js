function readCircleSuccess(data)
{
    // $("#circleList").append('<option value = NULL > Select a circle </option>')
    data.forEach(function(element){
        $("#circleList").append('<li><a href="#"  onclick="loadList('+element.circle_id+');">'+element.circle_name+'</a></li>');
    });
}

function loadList(circle_id){
    if (circle_id!=="NULL"){
        ajax(
            'pages/friends/viewCircleFriend',                       // PHP file to call on.
            {circle_id: circle_id},  // User_id from session goes here
            loadListSuccess                    // Callback method to use on success.
        );
        $('#addFriendToCircle').val(circle_id)
    }   
}

function loadListSuccess(friends){
    $("#friendCircleList").html("");
    if (friends['outcome']===1){
        var temp_circle_id = $('#addFriendToCircle').val();
        friends['response'].forEach(function(element){
            $("#friendCircleList").append('<button type="button" onclick="removeFriendFromCircle('+element.user_id+','+temp_circle_id+')" class="circleFriend btn btn-danger">DELETE</button>'+element.first_name + ' ' + element.last_name+'</br>');
        })
    }else{
        $("#friendCircleList").html("");
    }
}


function removeFriendFromCircle(friend_id,circle_id){
    ajax(
        'pages/friends/removeFriendFromCircle',                        // PHP file to call on.
        {friend_id:friend_id,circle_id: circle_id},    // Data from serialised form with user input.
        function success(){
            alert("Removed friend from circle successfully");
            loadList($('#addFriendToCircle').val());
        }                         // Callback method to use on success.
    );
};