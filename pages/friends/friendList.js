$("document").ready(function()
{
        Session.set('user_id',1);
        ajax(
            'pages/friends/friendList',                       // PHP file to call on.
            {user_id: Session.get('user_id')},  // User_id from session goes here
            readListSuccess                     // Callback method to use on success.
        );

        $("#friendList").on("click",(".lists"),function(){
            Session.set('friend_id',this.getAttribute("value"))
            window.location.assign("profile.html");
        });
});
function readListSuccess(data)
{

        data.forEach(function(element){
            $("#friendList").append('<li><a href="#" class="lists" value='+element.user_id+'><img class="friendimg" src="data:image/jpeg;base64,'+ element.photo_content + '"/><div><h3>' + element.first_name+' '+element.last_name + '</h3></div></a></li>')
        })
}