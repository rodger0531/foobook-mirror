
function readFriendSuccess(data)
{
    data.forEach(function(element){
        $("#friendslist").append('<li><a href="#" class="lists" value='+element.user_id+'><img class="friendpic" src="data:image/jpeg;base64,'+ element.photo_content + '" /><div><h3>' + element.first_name+' '+element.last_name + '</h3></div></a></li>');
    });
}