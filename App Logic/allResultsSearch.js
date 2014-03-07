$(document).ready(function(){
	allUserSearch(Session.get('search'));
	allGroupSearch(Session.get('search'));
	$('.searchBar').keyup(function(){
		if(Session.get('search') != undefined){
			Session.clear();
        }else{
        	search();
        }
    });
});

function allUserSearch(search){
    var search = search;
    $.ajax({
                type: 'POST',
                url: 'http://localhost/allUserSearch.php',
                data: {'search' : search},
                dataType: 'JSON',
                cache: false,
                success: successCallbackAllResultsUser,
                error: ajaxFailure
            });
}

function allGroupSearch(search){
    var search = search;
    $.ajax({
                type: 'POST',
                url: 'http://localhost/allGroupSearch.php',
                data: {'search' : search},
                dataType: 'JSON',
                cache: false,
                success: successCallbackAllResultsGroup,
                error: ajaxFailure
            });
}

function successCallbackAllResultsUser(data){
    if(data.outcome != 0){
        $('#content').append('<div class="showUsers">' + '<span style="float:left; border: 1px solid green; width:100%;">' + 'People' +'</span>' +'</div>');
        data.forEach(function(element){
            $('.showUsers').append('<div class="users" align="left" style="border:1px solid red; height:50px; padding:20px; margin-top:-1px;" name="'+ element.user_id +'">'+ 
            						'<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                    '<img src="data:image/jpeg;base64,'+ element.photo_content + '" style="width:50px; height:50px; float:left; margin-right:6px;" />' + 
                                    '<span style="margin-left: 10px;">' + element.first_name+' '+element.middle_name +' '+ element.last_name + '</span>'+
                                    '</a>' +
                                '</div>'
                            );
        });
    }
}

function successCallbackAllResultsGroup(data){
    if(data.outcome != 0){
        function delay(){ 
            $('#content').append('<div class="showGroups">' + '<span style="float:left; border: 1px solid green; width:100%;">' + 'Groups' +'</span>' +'</div>');
            data.forEach(function(element){
            $('.showGroups').append('<div class="groups" align="left" style="border:1px solid red; height:50px; padding:20px; margin-top:-1px;" name="'+ element.groups_id +'">'+ 
                                    	'<a href="#" onClick="profile();" style="text-decoration: none">' + 
                                            '<span style="margin-left: 10px;">' + element.name + '</span>'+
                                        '</a>' + 
                        			'</div>'
                            );
            });
        }
        setTimeout(function(){delay();},5);
    }
}