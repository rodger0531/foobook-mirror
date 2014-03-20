$(document).ready(function()
{
    if(Session.get('search') !== undefined)
    {
        allUserSearch(Session.get('search'));
        allGroupSearch(Session.get('search'));
    }

	// $('#showAllResults').hide();
	// $('#searchbar').keyup(function(){
	// 	if(Session.get('search') != undefined)
 //        {
	// 		Session.set('search', '');
 //        }
 //        else
 //        {
 //            search();
 //        }
 //    });
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
        $('.all-users-results').html('<div class="allUsers">' + '<span class="all-people">' + 'People' +'</span>' +'</div>');
        data.forEach(function(element){
            $('.allUsers').append('<div class="all-users" name="'+ element.user_id +'">'+ 
            						'<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                    '<img src="data:image/jpeg;base64,'+ element.photo_content + '"/>' + 
                                    '<span style="margin-left: 10px;">' + element.first_name+' '+element.middle_name +' '+ element.last_name + '</span>'+
                                    '</a>' +
                                '</div>'
                            );
        });
    }
}

function successCallbackAllResultsGroup(data)
{
    if(data.outcome != 0){
        function delay(){ 
            $('.all-groups-results').html('<div class="allGroups">' + '<span class="all-group">' + 'Groups' +'</span>' +'</div>');
            data.forEach(function(element){
            $('.allGroups').append('<div class="all-groups" align="left" name="'+ element.groups_id +'">'+ 
                                    	'<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                            '<span style="margin-left: 10px;">' + element.groups_name + '</span>'+
                                        '</a>' + 
                        			'</div>'
                            );
            });
        }
        setTimeout(function(){delay();},5);
    }
}