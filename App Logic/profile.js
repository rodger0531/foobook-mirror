function profile(){
    $('.showUsers').click(function(){
        var name = $(this).attr('name');
        window.location.assign("profile.html");
        alert(name);
    });

    $('.users').click(function(){
        var name = $(this).attr('name');
        window.location.assign("profile.html");
        alert(name);
    });

    $('.showGroups').click(function(){
        var name = $(this).attr('name');
        window.location.assign("profile.html");
        alert(name);
    });

    $('.groups').click(function(){
        var name = $(this).attr('name');
        window.location.assign("profile.html");
        alert(name);
    });
}