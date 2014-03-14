function searchFunctionality()
{
    $('#showAllResults').hide();
    $('.searchBar').keyup(function()
    {
        search();
    });
}

function search(){
    Session.set('search', $('.searchBar').val()); 
    if(Session.get('search') != undefined){
        $('#results').empty();
        userSearch(Session.get('search'));
        groupSearch(Session.get('search'));
    }else{
        Session.clear();
        $('.showUserResults').remove();
        $('.showGroupResults').remove();
        $('#showAllResults').hide();
        $('#results').html("");
    }
}

function userSearch(search){
    var search = search;
    $.ajax({
                type: 'POST',
                url: 'http://localhost/userSearch.php',
                data: {'search' : search},
                dataType: 'JSON',
                cache: false,
                success: successCallbackUser,
                error: ajaxFailure
            });
}

function groupSearch(search){
    var search = search;
    $.ajax({
                type: 'POST',
                url: 'http://localhost/groupSearch.php',
                data: {'search' : search},
                dataType: 'JSON',
                cache: false,
                success: successCallbackGroup,
                error: ajaxFailure
            });
}



function successCallbackUser(data)
{
    if(data.outcome != 0){
        $('#results').append('<div class="showUserResults">' + '<span style="float:left; border: 1px solid green; width:100%;">' + 'People' +'</span>' +'</div>');
        data.forEach(function(element){
            $('.showUserResults').append(   '<div class="showUsers" align="left" style="border:1px solid red; height:50px; padding:20px; margin-top:-1px;"  name="'+ element.user_id +'">'+ 
                                                '<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                                    '<img src="data:image/jpeg;base64,'+ element.photo_content + '" style="width:50px; height:50px; float:left; margin-right:6px;" />' + 
                                                    '<span style="margin-left: 10px;">' + element.first_name+' '+element.middle_name +' '+ element.last_name + '</span>'+
                                                '</a>' +
                                            '</div>' 
                                            
                            );
        });
        $('#showAllResults').show();
    }else{
        $('#showAllResults').hide();
    }
}

function successCallbackGroup(data)
{
    if(data.outcome != 0){
        function delay(){ 
            $('#results').append('<div class="showGroupResults">' + '<span style="float:left; border: 1px solid green; width:100%;">' + 'Groups' +'</span>' +'</div>');
            data.forEach(function(element){
            $('.showGroupResults').append(  '<div class="showGroups" align="left" style="border:1px solid red; height:50px; padding:20px; margin-top:-1px;" name="'+ element.groups_id +'">'+ 
                                                '<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                                    '<span style="margin-left: 10px;">' + element.name + '</span>'+
                                                '</a>' + 
                                            '</div>' 
                            );
            });
        }
        setTimeout(function(){delay();},500);
        $('#showAllResults').show();
    }else{
        $('#showAllResults').hide();
    }
}

function allResults()
{
    window.location.assign("allResults.html");
}

function profile()
{
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
