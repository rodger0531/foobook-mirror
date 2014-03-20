$(document).ready(function()
{
    if(Session.get('search') !== undefined)
    {
        allUserSearch(Session.get('search'));
        allGroupSearch(Session.get('search'));
        Session.set('search', '');
    }

    $('.all-users-results').on('click','.all-users',function () {
        var user_id = this.getAttribute('value');
        // window.location.assign('profile.html');
        alert(user_id);
    });

    $('.all-groups-results').on('click','.all-groups',function () {
        var user_id = this.getAttribute('value');
        // window.location.assign('profile.html');
        alert(user_id);
    });
});



function allUserSearch(search)
{
    var search = search;
    $.ajax({
                type: 'POST',
                url: 'http://localhost/pages/search/allUserSearch.php',
                data: {'search' : search},
                dataType: 'JSON',
                cache: false,
                success: successCallbackAllResultsUser,
                error: ajaxFailure
            });
}

function allGroupSearch(search)
{
    var search = search;
    $.ajax({
                type: 'POST',
                url: 'http://localhost/pages/search/allGroupSearch.php',
                data: {'search' : search},
                dataType: 'JSON',
                cache: false,
                success: successCallbackAllResultsGroup,
                error: ajaxFailure
            });
}

function successCallbackAllResultsUser(data)
{ 
    if(data.outcome != 0){
        $('.all-users-results').html('<div class="panel panel-info" ><div class="panel-heading"><h3 class="panel-title">People</h3></div><div class="panel-body" id="allUsers"></div></div>');
        data.forEach(function(element){
            $('#allUsers').append('<div class="all-users" value="'+ element.user_id +'">'+ 
            						'<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                    '<img src="data:image/jpeg;base64,'+ element.photo_content + '"/>' + 
                                    '<span style="margin-left: 10px;">' + element.first_name+' '+element.middle_name +' '+ element.last_name + '</span>'+
                                    '</a>' +
                                '</div>'
                            );
        });

        // Session.set('search', '');
    }
}

function successCallbackAllResultsGroup(data)
{
    if(data.outcome != 0){
        function delay(){ 
            $('.all-groups-results').html('<div class="panel panel-success" ><div class="panel-heading"><h3 class="panel-title">Group</h3></div><div class="panel-body" id="allGroups"></div></div>');
            data.forEach(function(element){
            $('#allGroups').append('<div class="all-groups" align="left" value="'+ element.groups_id +'">'+ 
                                    	'<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                            '<span style="margin-left: 10px;">' + element.groups_name + '</span>'+
                                        '</a>' + 
                        			'</div>'
                            );
            });
        }
        setTimeout(function(){delay();},5);
        // Session.set('search', '');
    }
}