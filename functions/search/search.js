
function userSearch(search){
    var search = search;
    $.ajax({
                type: 'POST',
                url: 'http://localhost/functions/search/userSearch.php',
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
                url: 'http://localhost/functions/search/groupSearch.php',
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
        $('#results-user').html('<div class="panel panel-info" id="userpanel"><div class="panel-heading"><h3 class="panel-title">People</h3></div><div class="panel-body" id="userbody"></div></div>');
        data.forEach(function(element){
            $('#userbody').append(   '<div id="usersmallpanel" align="left" value='+ element.user_id +'>'+ 
                                                    '<img src="data:image/jpeg;base64,'+ element.photo_content + '" style="width:50px; height:50px; float:left; margin-right:6px;">' + 
                                                    '<span style="margin-left: 10px; color: black;">' + element.first_name+' '+element.middle_name +' '+ element.last_name + '</span>'+
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
            $('#results-group').html('<div class="panel panel-success" id="grouppanel"><div class="panel-heading"><h3 class="panel-title">Group</h3></div><div class="panel-body" id="usergroup"></div></div>');
            data.forEach(function(element){
            $('#usergroup').append(  '<div id="groupsmallpanel" align="left" value="'+ element.groups_id +'">'+ 
                                                    '<span style="margin-left: 10px; color:black;">' + element.groups_name + '</span>'+
                                                '</a>' + 
                                            '</div>' 
                            );
            });
        }
        setTimeout(function(){delay();},50);
        $('#showAllResults').show();
    }else{
        $('#showAllResults').hide();
    }
}

function allResults()
{
    window.location.assign("allResults.html");
}