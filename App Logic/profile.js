function profile(){
    $('.showUsers').click(function(){
        var name = $(this).attr('name'); // alerts the user_id of the profile selected (used only for test purposes -- will be removed later)
        window.location.assign("profile.html");
        alert(name);
    });

    $('.users').click(function(){
        var name = $(this).attr('name'); // alerts the user_id of the profile selected (used only for test purposes -- will be removed later)
        window.location.assign("profile.html");
        alert(name);
    });

    $('.showGroups').click(function(){
        var name = $(this).attr('name'); // alerts the groups_id of the profile selected (used only for test purposes -- will be removed later)
        window.location.assign("profile.html");
        alert(name);
    });

    $('.groups').click(function(){
        var name = $(this).attr('name'); // alerts the groups_id of the profile selected (used only for test purposes -- will be removed later)
        window.location.assign("profile.html");
        alert(name);
    });
}